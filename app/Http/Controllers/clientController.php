<?php

namespace App\Http\Controllers;

use App\Http\Controllers\frontend\subscriptionController;
use App\Models\activation_codes;
use App\Models\clients;
use App\Models\packages;
use App\Models\subscriptions;
use App\Models\transactions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class clientController extends Controller
{
    public function view_client($id)
    {
        $plan = '';
        $ClientModel = new clients();
        $subsModel = Subscriptions::where('client_id', $id)
            ->orderByDesc('updated_at')
            ->where('status', '=', 1)
            ->first();
        if ($subsModel == null) {
            $plan = 'No plan';
        } else {
            $txn_data = transactions::where('txn_id', $subsModel->txn_id)->first();
            if ($txn_data != null) {
                if ($txn_data->txn_mode == 'Activation_code') {
                    $plan = 'Free plan';
                } else {
                    $plan = $txn_data->package_name;
                }
            } else {
                $plan = 'No plans';
            }
        }

        $txnModel = new transactions();
        $subs = new subscriptionController;
        $data = array(
            'client_id' => $id,
            'subs_status' => $subs->getSubStatus($id),
            'client_data' => $ClientModel->where('client_id', $id)->first(),
            'subscription_data' => $subsModel,
            'txn_data' => $txnModel->where('client_id', $id)->get()->toArray(),
            'plan' => $plan
        );


        return view('frontend.admin.pages.clients.view_client', $data);
    }
    public function generateTxnId()
    {
        $randomNumber = mt_rand(1000000, 9999999);

        while (transactions::where('txn_id', $randomNumber)->exists()) {
            $randomNumber = mt_rand(1000000, 9999999);
        }

        return $randomNumber;
    }

    public function update_subscription(Request $request)
    {
        if ($request->input('subs_id') == '') {
            try {
                $transaction = new transactions();
                $transaction->txn_id = $this->generateTxnId();
                $transaction->client_id = $request->input('client_id');
                $transaction->txn_type = 'PRIVATECH-DASHBOARD';
                $transaction->txn_mode = 'PRIVATECH-DASHBOARD';
                $transaction->net_amount = 0;
                $transaction->tax_amt = 0;
                $transaction->paid_amt =  0;
                $transaction->plan_validity_days =  $request->input('validity_days');
                $transaction->package_name = 0;
                $transaction->activation_code = 0;
                $transaction->status = 2;
                $transaction->price = 0;
                $transaction->created_by = session()->get('user_id');
                $transaction_id = $transaction->txn_id;
                $transaction->save();
                $daysToAdd = $request->input('validity_days');

                $lastSubscription = Subscriptions::where('client_id', $request->input('client_id'))
                    ->whereNull('validity_days')
                    ->latest()
                    ->first();
                if ($lastSubscription) {
                    $lastSubscription->txn_id = $transaction_id;
                    $lastSubscription->started_at = now();
                    $lastSubscription->ends_on = now()->addDays($daysToAdd);
                    $lastSubscription->status = 1;
                    $lastSubscription->validity_days = $request->input('validity_days');
                    $lastSubscription->save();
                } else {
                    $update_date = Subscriptions::where('client_id', $request->input('user_id'))
                        ->select('ends_on')
                        ->orderByDesc('updated_at')
                        ->where('status', '=', 1)
                        ->first();

                    $subscription = new subscriptions();
                    $subscription->client_id = $request->input('user_id');
                    $subscription->txn_id = $transaction_id;
                    $subscription->started_at = now();
                    $subscription->status = 1;
                    $subscription->ends_on = now()->addDays($daysToAdd);
                    $subscription->validity_days = $request->input('validity_days');
                    $subscription->save();
                }
                session()->flash('success', 'Subscription updated successfully');
                return redirect()->route('view_client', ['id' => $request->input('client_id')]);
            } catch (\Exception $e) {

                Log::error('Error creating user: ' . $e->getMessage());

                Session::flash('error', $e->getMessage());
                return redirect()->route('view_client', ['id' => $request->input('client_id')]);
            }
        }


        $validator = Validator::make($request->all(), [
            'validity_days' => 'required',
        ]);
        if ($validator->fails()) {
            session()->flash('error', $validator->errors());
            return redirect()->route('view_client', ['id' => $request->input('client_id')]);
        }
        $data = subscriptions::where('subs_id', $request->input('subs_id'))->first();
        if ($data != null) {
            if ($data->ends_on < date('Y-m-d')) {
                $data->ends_on =  date('Y-m-d', strtotime('+ ' . $request->input('validity_days') . ' days'));
                $data->save();
            } else {
                $daysToAdd = $request->input('validity_days');
                $data->ends_on =  date('Y-m-d', strtotime($data->ends_on . " +$daysToAdd days"));
                $data->save();
            }
            session()->flash('success', 'Subscription updated successfully');
            return redirect()->route('view_client', ['id' => $request->input('client_id')]);
        }
    }

    public function delete_client(Request $request)
    {
        $data = clients::where('client_id', $request->input('client_id'))->first();
        $data->delete();
        session()->flash('success', 'Subscription deleted successfully');
        return redirect()->back();
    }

    public function update_client(Request $request)
    {
        $client = clients::where('client_id', '=', $request->input('row_id'))->first();
        $client->name = $request->input('name');
        $client->email = $request->input('email');
        $client->mobile_number = $request->input('mobile');
        $client->status = $request->input('status');
        $client->save();
        return redirect()->route('view_client', ['id' => $request->input('row_id')]);
    }

    public function update_client_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password'
        ]);
        if ($validator->fails()) {

            $ClientModel = new clients();
            $subsModel = new subscriptions();
            $txnModel = new transactions();
            $subs = new subscriptionController;
            $data = array(
                'client_id' => $request->input('row_id'),
                'subs_status' => $subs->getSubStatus($request->input('row_id')),
                'client_data' => $ClientModel->where('client_id', $request->input('row_id'))->first(),
                'subscription_data' => $subsModel->where('client_id', $request->input('row_id'))->first(),
                'txn_data' => $txnModel->where('client_id', $request->input('row_id'))->get()->toArray(),
            );
            session()->flash('error', $validator->errors());
            return view('frontend.admin.pages.clients.view_client', $data)->with(['error' => $validator->errors()]);
        } else {
            $client = clients::where('client_id', '=', $request->input('row_id'))->first();
            $client->password = bcrypt($request->input('password'));
            $client->save();
            session()->flash('success', 'Password updated successfully');

            $ClientModel = new clients();
            $subsModel = new subscriptions();
            $txnModel = new transactions();
            $subs = new subscriptionController;
            $data = array(
                'client_id' => $request->input('row_id'),
                'subs_status' => $subs->getSubStatus($request->input('row_id')),
                'client_data' => $ClientModel->where('client_id', $request->input('row_id'))->first(),
                'subscription_data' => $subsModel->where('client_id', $request->input('row_id'))->first(),
                'txn_data' => $txnModel->where('client_id', $request->input('row_id'))->get()->toArray(),
            );
            session()->flash('success', 'Password updated successfully');
            return view('frontend.admin.pages.clients.view_client', $data);
        }
    }

    public function profile_index()
    {
        $data = clients::where('client_id', session('user_id'))->first();
        return view('frontend.pages.profile.index')->with(['data' => $data]);
    }

    public function profile_update_frontend(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'password' => 'required|min:8',
                'confirm_password' => 'required|same:password'
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            } else {
                $client = clients::where('client_id', '=', session('user_id'))->first();
                $client->password = bcrypt($request->input('password'));
                $client->save();
                session()->flash('success', 'Password updated successfully');
                return redirect()->route('home');
            }
            return redirect()->route('profile');
        } catch (ValidationException $e) {

            return redirect()->route('home')->withErrors($e->errors())->withInput();
        }
    }

    public function default_device($id, $token)
    {
        $client = clients::where('client_id', session('user_id'))->first();
        $client->update(['device_id' => $id, 'device_token' => $token]);
        return redirect()->back()->with(['userId' => session('user_id')]);
    }
}
