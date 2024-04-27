<?php

namespace App\Http\Controllers;

use App\Models\payments;
use App\Models\storage_txn;
use App\Models\subscriptions;
use App\Models\transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Razorpay\Api\Api;

class RazorpayController extends Controller
{
    public function createApi()
    {

        return new Api(getenv('RAZORPAY_KEY'), getenv('RAZORPAY_SECRET'));
        // return new Api('rzp_test_MybG7Zi1r7BIIZ', 'mP17Yqy2Y10qgkbsE9QjhVeF');
    }

    public function success(Request $request)
    {
        try {
            $api = $this->createApi();
            if (!$request->has('razorpay_order_id')) {
                Session::flash('error', 'Invalid order ID');
                return redirect()->route('/subscription/packages');
            }
            $order = transactions::where('razorpay_order_id', $request->razorpay_order_id)->first();
            if (!$order) {
                Session::flash('error', 'Order ID not found');
                return redirect()->route('/subscription/packages');
            }
            $api->utility->verifyPaymentSignature(array(
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ));
            $order = $api->order->fetch($request->razorpay_order_id);
            if ($order->status == 'paid') {
                $transaction = transactions::where('razorpay_order_id', $request->razorpay_order_id)->first();
                $transaction->update([
                    'status' => 2,
                    'redirected' => true,
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                ]);
                if ($transaction->storage_id != null) {
                    $storage_txn = storage_txn::where('txn_id', $transaction->txn_id)->first();
                    if ($storage_txn != null) {
                        $storage_txn->update([
                            'status' => 1
                        ]);
                    }
                } else {
                    $subscription = subscriptions::where('txn_id', $transaction->txn_id)->first();
                    if ($subscription != null) {
                        $subscription->update([
                            'status' => 1
                        ]);
                    }
                }

                Session::flash('success', 'Payment successfull');
                return redirect()->route('home');
            } else {
                Session::flash('error', 'Payment failed. Please try again later');
                return redirect()->route('/subscription/packages');
            }
        } catch (\Exception $e) {
            Log::error('error: ' . $e->getMessage());
            return redirect()->route('/subscription/packages')->dangerBanner($e->getMessage());
        }
    }
    public function webhook(Request $request)
    {
        $data = $request->all();
        $webhookSignature = $request->header('X-Razorpay-Signature');
        $api = $this->createApi();
        // $webhook_secret = config('services.razorpay.webhook_secret');
        $webhook_secret = getenv('WEBHOOK_SECRET');
        try {
            $api->utility->verifyWebhookSignature($request->getContent(), $webhookSignature, $webhook_secret);
            if ($data['event'] == 'payment.captured') {
                $order_id = $data['payload']['payment']['entity']['order_id'];
                $payment = transactions::where('razorpay_order_id', $order_id)->first();
                $order = $api->order->fetch($order_id);
                Log::error('webhook 2');
                if ($order->status == 'paid') {
                    $payment->update([
                        'status' => 2,
                        'razorpay_payment_id' => $data['payload']['payment']['entity']['id'],
                    ]);
                    if ($payment->storage_id != null) {
                        $storage_txn = storage_txn::where('txn_id', $payment->storage_id)->first();
                        if ($storage_txn != null) {
                            $storage_txn->update([
                                'status' => 1
                            ]);
                        }
                    } else {
                        $subscription = subscriptions::where('txn_id', $payment->txn_id)->first();
                        $subscription->update([
                            'status' => 1
                        ]);
                    }
                    Log::error('webhook 3');
                    return response()->json([
                        'success' => 'Payment successful.'
                    ], 200);
                } else {
                    Log::error('webhook 4');
                    return response()->json([
                        'error' => 'Payment failed.'
                    ], 400);
                }
            }
            if ($data['event'] == 'payment.failed') {
                $order_id = $data['payload']['payment']['entity']['order_id'];
                $payment = transactions::where('razorpay_order_id', $order_id)->first();

                $payment->update([
                    'status' => 1,

                    'razorpay_payment_id' => $data['payload']['payment']['entity']['id'],
                ]);

                return response()->json([
                    'error' => 'Payment failed.'
                ], 400);
            }
        } catch (\Exception $e) {
            Log::error('error: ' . $e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
