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

        return view('Frontend/pages/subscription/purchase', $data);
    }

    public function checkout(Request $request)
    {
        try {
            if ($request->input('code_name') != "") {
                $code = activation_codes::where('code', $request->input('code_name'))->first();
                $package = packages::where('id', $request->input('package_id'))->first();
                if ($code == null) {
                    return back();
                } else {

                    if ($code->price >= $request->input('total_amount')) {
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
                        $transaction->status = 1;
                        $transaction->price = $request->input('total_amount');
                        $transaction->created_by = session()->get('user_id');
                        $transaction_id = $transaction->txn_id;
                        $transaction->save();
                        $daysToAdd = $package->duration_in_days;
                        $subscription = new subscriptions();
                        $subscription->client_id = $request->input('user_id');
                        $subscription->txn_id = $transaction_id;
                        $subscription->started_at = date('Y-m-d');
                        $subscription->ends_on = date('Y-m-d', strtotime(date('Y-m-d') . " +$daysToAdd days"));
                        $subscription->validity_days = $package->duration_in_days;
                        $subscription->save();

                        $code->is_active = 0;
                        $code->save();
                        Session::flash('success', 'Payment Success');
                        return redirect()->route('home');
                    } else {
                        Session::flash('error', 'Activation code amount is low');
                        return redirect()->route('home');
                    }
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
            ->count();

        if ($expiredSubscriptions > 0) {
            $tmp_value = '<span class="text-danger">EXPIRED</span>';
        }

        $activeSubscriptionEndDate = subscriptions::where('client_id', $id)
            ->where('status', 1)
            ->where('ends_on', '>=', $today)
            ->value('ends_on');

        if ($activeSubscriptionEndDate) {
            $tmp_value = $activeSubscriptionEndDate;
        }

        return $tmp_value;
    }
}
