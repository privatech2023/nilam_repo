<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UplineController;
use App\Models\activation_codes;
use App\Models\clients;
use App\Models\coupons;
use App\Models\commissions;
use App\Models\earnings;
use App\Models\packages;
use App\Models\storage;
use App\Models\subscriptions;
use App\Models\transactions;
use App\Models\user_clients;
use App\Models\user_groups;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Razorpay\Api\Api;
use Illuminate\Support\Str;

class subscriptionController extends Controller
{
    public function index()
    {
        $logged_user = session()->get('user_id');
        $client = clients::where('client_id', $logged_user)->first();
        Session::put('name', $client->user);
        Session::put('email', $client->email);
        Session::put('contact', $client->mobile_number);
        Session::put('storage', 0);
        // return view('frontend.pages.subscription.index', $data);

        $storages = storage::where('status', 1)->get();

        $packages = packages::where('is_active', 1)->get();
        $data = [
            'pageTitle' => 'PRIVATECH-SUBSCRIPTION',
            'packages' => $packages,
        ];
        return view('frontend.pages.subscription.packages', $data)->with(['storages' => $storages]);
    }
    // public function packages()
    // {
    //     $packages = packages::where('is_active', 1)->get();
    //     $data = [
    //         'pageTitle' => 'PRIVATECH-SUBSCRIPTION',
    //         'packages' => $packages,
    //     ];
    //     return view('frontend.pages.subscription.packages', $data);
    // }

    public function createApi()
    {
        $id = config('services.razorpay.key');
        $secret = config('services.razorpay.secret');
        return new Api($id, $secret);
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
                $code = activation_codes::whereRaw('BINARY code = ?', [$request->input('code_name')])->first();
                if ($code == null) {
                    $packageModel = packages::all();
                    $data = array(
                        'pageTitle' => 'PRIVATECH-SUBSCRIPTION',
                    );
                    Session::flash('error', 'Invalid activation code');
                    return redirect()->back();
                } elseif ($code != null && $code->is_active == 0) {

                    Session::flash('error', 'Activation code is already used');

                    return redirect()->back();
                } else {
                    // $user_mapped = user_clients::where('client_id', $request->input('user_id'))->first();

                    if ($code->is_active == 0) {
                        Session::flash('error', 'Activation code is already used');
                        return redirect()->back();
                    } elseif ($code->expiry_date < date('Y-m-d')) {
                        Session::flash('error', 'Activation code is expired');
                        return redirect()->back();
                    }
                    $transaction = new transactions();
                    $transaction->txn_id = $this->generateTxnId();
                    $transaction->client_id = $request->input('user_id');
                    $transaction->txn_type = 'Activation_code';
                    $transaction->txn_mode = 'Activation_code';
                    $transaction->net_amount = $code->net_amount;
                    $transaction->tax_amt = $code->tax;
                    $transaction->paid_amt =  $code->price;
                    $transaction->plan_validity_days = $code->duration_in_days;
                    $transaction->package_name = null;
                    $transaction->activation_id = $code->c_id;
                    $transaction->activation_code = $request->input('code_name');
                    $transaction->status = 2;
                    $transaction->price = $code->price;
                    $transaction->created_by = session()->get('user_id');
                    $transaction_id = $transaction->txn_id;
                    $transaction->save();
                    $daysToAdd = $code->duration_in_days;

                    $lastSubscription = Subscriptions::where('client_id', $request->input('user_id'))
                        ->whereNull('validity_days')
                        ->latest()
                        ->first();
                    if ($lastSubscription) {
                        $lastSubscription->txn_id = $transaction_id;
                        $lastSubscription->started_at = date('Y-m-d');
                        $lastSubscription->ends_on = date('Y-m-d', strtotime("+$daysToAdd days"));
                        $lastSubscription->status = 1;
                        $lastSubscription->validity_days = $code->duration_in_days;
                        $lastSubscription->devices = $code->devices;
                        $lastSubscription->promoter_id = $user_mapped->user_id;
                        $lastSubscription->is_previous = 1;
                        $lastSubscription->save();
                    } else {
                        $update_date = Subscriptions::where('client_id', $request->input('user_id'))
                            ->select('ends_on')
                            ->orderByDesc('ends_on')
                            ->where('status', '=', 1)
                            ->first();
                        $start_date = '';
                        $end_date = '';
                        if ($update_date != null) {
                            $end_date = date('Y-m-d', strtotime($update_date->ends_on . " +$daysToAdd days"));
                            if (strtotime($update_date->ends_on) < strtotime(date('Y-m-d'))) {
                                $start_date = date('Y-m-d', strtotime($update_date->ends_on));
                            } else {
                                $start_date =  date('Y-m-d');
                            }
                        } else {
                            $start_date = date('Y-m-d');
                            $end_date = date('Y-m-d', strtotime("+$daysToAdd days"));
                        }
                        $subscription = new subscriptions();
                        $subscription->client_id = $request->input('user_id');
                        $subscription->txn_id = $transaction_id;
                        $subscription->started_at = $start_date;
                        $subscription->status = 1;
                        $subscription->ends_on = $end_date;
                        $subscription->validity_days = $code->duration_in_days;
                        $subscription->devices = $code->devices;
                        $subscription->promoter_id = $user_mapped->user_id;
                        $subscription->is_previous = 1;
                        $subscription->save();
                    }
                    $code->is_active = 0;
                    $code->used_by = $request->input('user_id');
                    $code->save();

                    // $group = user_groups::where('u_id', $user_mapped->user_id)->first();
                    // $commission = commissions::where('group_id', $group->g_id)->orderBy('created_at', 'desc')->first();

                    // earnings::create([
                    //     'user_id' => $user_mapped->user_id,
                    //     'commission' => $commission->commission,
                    //     'client_id' => $request->input('user_id')
                    // ]);

                    // $upline_earning = new UplineController;
                    // $upline_earning->upline_commission($user_mapped->user_id);
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
            ->orderByDesc('updated_at')
            ->first();

        if (!is_null($expiredSubscriptions)) {
            $tmp_value = '<span class="text-danger">EXPIRED</span>';
        }

        $activeSubscriptionEndDate = subscriptions::where('client_id', $id)
            ->where('status', 1)
            ->where('ends_on', '>=', $today)
            ->orderByDesc('updated_at')
            ->value('ends_on');

        if ($activeSubscriptionEndDate) {
            $tmp_value = $activeSubscriptionEndDate;
        }

        return $tmp_value;
    }

    public function checkout(Request $request)
    {
        try {
            $client = clients::where('client_id', session('user_id'))->first();
            $receipt = (string) str::uuid();
            $package = packages::where('id', $request->input('package_id'))->first();

            $amountInPaise = (int)($request->input('pay_amount') * 100);

            $api = new Api(getenv('RAZORPAY_KEY'), getenv('RAZORPAY_SECRET'));
            // $api = new Api('rzp_test_MybG7Zi1r7BIIZ', 'mP17Yqy2Y10qgkbsE9QjhVeF');
            $razorCreate = $api->order->create(array(
                'receipt' => $receipt,
                'amount' => $amountInPaise,
                'currency' => 'INR',
                'notes' => array('key1' => 'value1', 'key2' => 'value2', 'key3' => 'value3')
            ));

            $user_mapped = user_clients::where('client_id', $request->input('user_id'))->first();

            $transaction = new transactions();
            $transaction->txn_id = $receipt;
            $transaction->client_id = $request->input('user_id');
            $transaction->txn_type = 'Online payment';
            $transaction->txn_mode = 'Razorpay';
            $transaction->net_amount = $package->net_amount;
            $transaction->tax_amt = $package->tax;
            $transaction->paid_amt =  $request->input('pay_amount');
            $transaction->plan_validity_days = $package->duration_in_days;
            $transaction->package_name = $package->name;
            $transaction->activation_code = null;
            $transaction->status = 1;
            $transaction->price = $package->price;
            $transaction->created_by = session()->get('user_id');
            $transaction->razorpay_order_id = $razorCreate->id;
            $transaction_id = $transaction->txn_id;
            $transaction->save();

            $daysToAdd = $package->duration_in_days;

            $lastSubscription = Subscriptions::where('client_id', $request->input('user_id'))
                ->whereNull('validity_days')
                ->latest()
                ->first();
            if ($lastSubscription) {
                $lastSubscription->txn_id = $transaction_id;
                $lastSubscription->started_at = date('Y-m-d');
                $lastSubscription->ends_on = date('Y-m-d', strtotime("+$daysToAdd days"));
                $lastSubscription->status = 0;
                $lastSubscription->validity_days = $package->duration_in_days;
                $lastSubscription->devices = $package->devices;
                $lastSubscription->promoter_id = $user_mapped->user_id;
                $lastSubscription->is_previous = 1;
                $lastSubscription->save();
            } else {
                $update_date = subscriptions::where('client_id', $request->input('user_id'))
                    ->select('ends_on')
                    ->orderByDesc('updated_at')
                    ->where('status', '=', 1)
                    ->first();
                $start_date = '';
                $end_date = '';
                if ($update_date != null) {
                    $end_date = date('Y-m-d', strtotime($update_date->ends_on . " +$daysToAdd days"));
                    if (strtotime($update_date->ends_on) < strtotime(date('Y-m-d'))) {
                        $start_date = date('Y-m-d', strtotime($update_date->ends_on));
                    } else {
                        $start_date =  date('Y-m-d');
                    }
                } else {
                    $start_date = date('Y-m-d');
                    $end_date = date('Y-m-d', strtotime("+$daysToAdd days"));
                }
                $subscription = new subscriptions();
                $subscription->client_id = $request->input('user_id');
                $subscription->txn_id = $transaction_id;
                $subscription->started_at =  $start_date;
                $subscription->status = 0;
                $subscription->ends_on =  $end_date;
                $subscription->validity_days = $package->duration_in_days;
                $subscription->devices = $package->devices;
                $subscription->promoter_id = $user_mapped->user_id;
                $subscription->is_previous = 1;
                $subscription->save();
            }
            $data = [
                'amount' => $razorCreate['amount'],
                'id' => $razorCreate['id'],
                'key' => getenv('RAZORPAY_KEY'),
                // 'key' => "rzp_test_MybG7Zi1r7BIIZ"
            ];
            return response()->json($data);
        } catch (Exception $e) {
            Log::error('Error : ' . $e->getMessage());

            return redirect()->back();
        }
    }



    public function onlinePayment(Request $request)
    {
        $id = $request->input('package-id');
        $amount = $request->input('payable-amount');
        return view('frontend.pages.subscription.online_payment')->with(['payableAmount' => $amount, 'packageId' => $id]);
    }
}
