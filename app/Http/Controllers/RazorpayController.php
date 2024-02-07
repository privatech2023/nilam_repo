<?php

namespace App\Http\Controllers;

use App\Models\payments;
use App\Models\subscriptions;
use App\Models\transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Razorpay\Api\Api;

class RazorpayController extends Controller
{
    public function createApi()
    {
        $key = config('services.razorpay.key');
        $secret = config('services.razorpay.secret');

        return new Api($key, $secret);
    }

    public function success(Request $request)
    {
        try {
            $api = $this->createApi();
            if (!$request->has('razorpay_order_id')) {
                Session::flash('error', 'Invalid order ID');
                return redirect()->route('/subscription/packages');
            }

            // Check if order exists in database
            $order = payments::where('razorpay_order_id', $request->razorpay_order_id)->first();

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



            // If order status is paid
            if ($order->status == 'paid') {
                $transaction = transactions::where('razorpay_order_id', $request->razorpay_order_id)->first();

                $transaction->update([
                    'payment_status' => 2,
                    'redirected' => true,
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'razorpay_signature' => $request->razorpay_signature,
                ]);

                $subscription = subscriptions::where('txn_id', $transaction->txn_id)->first();

                $subscription->update([
                    'status' => 1
                ]);
                Session::flash('success', 'Payment successfull');
                return redirect()->route('/subscription/packages');
            } else {
                Session::flash('error', 'Payment failed');
                return redirect()->route('/subscription/packages');
            }
        } catch (\Exception $e) {
            return redirect()->route('/subscription/packages')->dangerBanner($e->getMessage());
        }
    }

    public function webhook(Request $request)
    {
        $data = $request->all();
        $webhookSignature = $request->header('X-Razorpay-Signature');

        $api = $this->createApi();
        $webhook_secret = config('services.razorpay.webhook_secret');

        try {
            $api->utility->verifyWebhookSignature($request->getContent(), $webhookSignature, $webhook_secret);
            if ($data['event'] == 'payment.captured') {
                $order_id = $data['payload']['payment']['entity']['order_id'];

                $payment = transactions::where('razorpay_order_id', $order_id)->first();

                $order = $api->order->fetch($order_id);

                if ($order->status == 'paid') {
                    $payment->update([
                        'payment_status' => 'success',

                        'razorpay_payment_id' => $data['payload']['payment']['entity']['id'],
                        'razorpay_signature' => $webhookSignature,
                    ]);

                    $subscription = $payment->subscription;

                    $subscription->update([
                        'status' => 'paid'
                    ]);

                    return response()->json([
                        'success' => 'Payment successful.'
                    ], 200);
                } else {
                    return response()->json([
                        'error' => 'Payment failed.'
                    ], 400);
                }
            }

            // If webhook is for payment failed
            if ($data['event'] == 'payment.failed') {
                $order_id = $data['payload']['payment']['entity']['order_id'];

                $payment = transactions::where('razorpay_order_id', $order_id)->first();

                $payment->update([
                    'payment_status' => 'failed',

                    'razorpay_payment_id' => $data['payload']['payment']['entity']['id'],
                    'razorpay_signature' => $webhookSignature,

                    'failure_reason' => $data['payload']['payment']['entity']['error_code'],
                    'failure_message' => $data['payload']['payment']['entity']['error_description'],
                ]);

                return response()->json([
                    'error' => 'Payment failed.'
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
