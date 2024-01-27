<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\activation_codes;
use App\Models\coupons;
use App\Models\packages;
use App\Models\subscriptions;
use App\Models\transactions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Razorpay\Api\Api as ApiApi;
use Spatie\FlareClient\Api;

class subscriptionController extends Controller
{
    public function index()
    {
        $logged_user = session()->get('user_id');
        $data = array(
            'subs_status' => $this->getSubStatus($logged_user),
        );
        return view('frontend.pages.subscription.index', $data);
    }


    public function packages()
    {
        $packages = packages::all();

        $data = [
            'pageTitle' => 'PRIVATECH-SUBSCRIPTION',
            'packages' => $packages,
        ];
        return view('frontend.pages.subscription.packages', $data);
    }

    public function purchasePackage($id)
    {
        $packageModel = packages::all();
        $data = array(
            'pageTitle' => 'PRIVATECH-SUBSCRIPTION',
            'package' => $packageModel->where('id', $id)->first(),
        );

       return view('frontend.pages.subscription.purchase', $data);
    }



    public function checkout_activation_code(Request $request)
    {
        try {
            if ($request->input('code_name') != "") {
                // $code = activation_codes::where('code', $request->input('code_name'))->first();
                $code = activation_codes::whereRaw('BINARY code = ?', [$request->input('code_name')])->first();

                $package = packages::where('id', $request->input('package_id'))->first();
                if ($code == null || $code->is_active == 0) {
                    $packageModel = packages::all();
                    $data = array(
                        'pageTitle' => 'PRIVATECH-SUBSCRIPTION',
                        'package' => $packageModel->where('id', $request->input('package_id'))->first(),
                    );
                    Session::flash('error', 'Invalid activation code');
                    return view('frontend.pages.subscription.purchase', $data);
                } else {
                    if ($code->is_active == 0) {
                        Session::flash('error', 'Activation code is already used');
                        return redirect()->route('home');
                    } elseif ($code->expiry_date < date('Y-m-d')) {
                        Session::flash('error', 'Activation code is expired');
                        return redirect()->route('home');
                    }
                    $transaction = new transactions();
                    $transaction->txn_id = $this->generateTxnId();
                    $transaction->client_id = $request->input('user_id');
                    $transaction->txn_type = 'Activation_code';
                    $transaction->txn_mode = 'Activation_code';
                    $transaction->net_amount = $request->input('total_amount');
                    $transaction->tax_amt = $code->tax;
                    $transaction->paid_amt =  $request->input('total_amount');
                    $transaction->plan_validity_days = $package->duration_in_days;
                    $transaction->package_name = $package->name;
                    $transaction->activation_code = $request->input('code_name');
                    $transaction->status = 2;
                    $transaction->price = $request->input('total_amount');
                    $transaction->created_by = session()->get('user_id');
                    $transaction_id = $transaction->txn_id;
                    $transaction->save();
                    $daysToAdd = $package->duration_in_days;


                    $lastSubscription = Subscriptions::where('client_id', $request->input('user_id'))
                        ->whereNull('validity_days')
                        ->latest()
                        ->first();
                    if ($lastSubscription) {
                        $lastSubscription->txn_id = $transaction_id;
                        $lastSubscription->started_at = now();
                        $lastSubscription->ends_on = now()->addDays($daysToAdd);
                        $lastSubscription->status = 1;
                        $lastSubscription->validity_days = $package->duration_in_days;
                        $lastSubscription->save();
                    } else {

                        $update_date = Subscriptions::where('client_id', $request->input('user_id'))
                            ->select('ends_on')
                            ->orderByDesc('ends_on')
                            ->first();


                        $subscription = new subscriptions();
                        $subscription->client_id = $request->input('user_id');
                        $subscription->txn_id = $transaction_id;
                        $subscription->started_at = date('Y-m-d', strtotime($update_date->ends_on));
                        $subscription->status = 1;
                        $subscription->ends_on = date('Y-m-d', strtotime($update_date->ends_on . " +$daysToAdd days"));
                        $subscription->validity_days = $package->duration_in_days;
                        $subscription->save();
                    }

                    $code->is_active = 0;
                    $code->save();
                    Session::flash('success', 'Payment Success');
                    return redirect()->route('home');
                }
            }
        } catch (\Exception $e) {

            Log::error('Error creating user: ' . $e->getMessage());

            Session::flash('error', $e->getMessage());
            return redirect()->route('home');
        }
    }


    public function generateTxnId()
    {
        $randomNumber = mt_rand(1000000, 9999999);

        while (transactions::where('txn_id', $randomNumber)->exists()) {
            $randomNumber = mt_rand(1000000, 9999999);
        }

        return $randomNumber;
    }

    public function getSubStatus($id)
    {
        $tmp_value = '';
        $today = Carbon::today('Asia/Kolkata');

        $pendingSubscriptions = subscriptions::where('client_id', $id)
            ->whereNull('validity_days')
            ->whereNull('started_at')
            ->whereNull('ends_on')
            ->count();


        if ($pendingSubscriptions > 0 || $pendingSubscriptions == null) {
            $tmp_value = '<span class="text-warning">PENDING</span>';
        }

        $expiredSubscriptions = subscriptions::where('client_id', $id)
            ->where('status', 1)
            ->where('ends_on', '<', $today)
            ->orderByDesc('started_at')
            ->first();

        if (!is_null($expiredSubscriptions)) {
            $tmp_value = '<span class="text-danger">EXPIRED</span>';
        }

        $activeSubscriptionEndDate = subscriptions::where('client_id', $id)
            ->where('status', 1)
            ->where('ends_on', '>=', $today)
            ->orderByDesc('ends_on')
            ->value('ends_on');

        if ($activeSubscriptionEndDate) {
            $tmp_value = $activeSubscriptionEndDate;
        }

        return $tmp_value;
    }

    public function checkout(Request $request)
    {
        if ($request->input('coupon_name') != null) {
            $coupon = coupons::whereRaw('BINARY coupon = ?', [$request->input('coupon_name')])->first();
            if ($coupon === null || $coupon->is_active == 0) {
                $id = $request->input('package_id');
                $amount = $request->input('pay-amount');
                Session::flash('error', 'Invalid coupon code');
                return view('frontend.pages.subscription.online_payment')->with(['payableAmount' => $amount, 'packageId' => $id]);
            } else {
                $newAmount = (int)($request->input('pay-amount')) - (($coupon->discount_percentage / 100) * $request->input('pay-amount'));
                $amountInPaise = (int)($newAmount * 100);
                $api = new ApiApi(getenv('RAZORPAY_KEY_ID'), getenv('RAZORPAY_KEY_SECRET'));
                $razorCreate = $api->order->create(array(
                    'receipt' => '123',
                    'amount' => $amountInPaise,
                    'currency' => 'INR',
                    'notes' => array('key1' => 'value3', 'key2' => 'value2')
                ));

                $data['razorPay'] = $razorCreate;
                return view('Frontend/razorpay/checkout', $data);

                // $id = $request->input('package_id');
                // $amount = $request->input('pay-amount');
                // Session::flash('success', 'Coupon code valid');
                // return view('frontend.pages.subscription.online_payment')->with(['payableAmount' => $amount, 'packageId' => $id]);
            }
        }
        //add transaction mode to online.
        $amountInPaise = (int)($request->input('pay-amount') * 100);
        $api = new ApiApi(getenv('RAZORPAY_KEY_ID'), getenv('RAZORPAY_KEY_SECRET'));
        $razorCreate = $api->order->create(array(
            'receipt' => '123',
            'amount' => $amountInPaise,
            'currency' => 'INR',
            'notes' => array('key1' => 'value3', 'key2' => 'value2')
        ));

        $data['razorPay'] = $razorCreate;
        return view('Frontend/razorpay/checkout', $data);
    }

    public function onlinePayment(Request $request)
    {
        $id = $request->input('package-id');
        $amount = $request->input('payable-amount');
        return view('frontend.pages.subscription.online_payment')->with(['payableAmount' => $amount, 'packageId' => $id]);
    }
}
