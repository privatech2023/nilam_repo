<?php

namespace App\Http\Controllers;

use App\Models\clients;
use App\Models\manual_txns;
use App\Models\subscriptions;
use App\Models\transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ManualTransactions extends Controller
{
    public function manual(Request $request)
    {
        try {
            $validatedData =  Validator::make($request->all(), [
                'client_mobile' => 'required',
                'storage' => 'required|numeric|min:0',
                'storage_validity' => 'required',
                'device' => 'required|numeric|min:0',
                'subscription_validity' => 'required|numeric|min:0'
            ]);
            $cl = clients::where('mobile_number', $request->input('client_mobile'))->first();
            if ($validatedData->fails()) {
                Session::flash('error', $validatedData->errors());
                return redirect()->route('/admin/managePackages');
            } elseif ($cl == null) {
                Session::flash('error', 'No client found with this mobile number');
                return redirect()->back();
            }


            try {
                $transaction = new transactions();
                $transaction->txn_id = (string) Str::uuid();
                $transaction->client_id = $cl->client_id;
                $transaction->txn_type = 'MANUAL';
                $transaction->txn_mode = 'MANUAL';
                $transaction->net_amount = 0;
                $transaction->tax_amt = 0;
                $transaction->paid_amt =  0;
                $transaction->plan_validity_days =  $request->input('subscription_validity');
                $transaction->package_name = 0;
                $transaction->activation_code = 0;
                $transaction->status = 2;
                $transaction->price = 0;
                $transaction->created_by = session()->get('user_id');
                $transaction_id = $transaction->txn_id;
                $transaction->save();
                $daysToAdd = $request->input('subscription_validity');

                $lastSubscription = subscriptions::where('client_id', $cl->client_id)
                    ->whereNull('validity_days')
                    ->latest()
                    ->first();
                if ($lastSubscription) {
                    $lastSubscription->txn_id = $transaction_id;
                    $lastSubscription->started_at = now();
                    $lastSubscription->ends_on = now()->addDays($daysToAdd);
                    $lastSubscription->status = 1;
                    $lastSubscription->validity_days = $request->input('subscription_validity');
                    $lastSubscription->save();
                } else {
                    $subscription = new subscriptions();
                    $subscription->client_id = $cl->client_id;
                    $subscription->txn_id = $transaction_id;
                    $subscription->started_at = now();
                    $subscription->status = 1;
                    $subscription->ends_on = now()->addDays($daysToAdd);
                    $subscription->validity_days = $request->input('subscription_validity');
                    $subscription->save();
                }

                $manual = new manual_txns();
                $manual->client_id = $cl->client_id;
                $manual->txn_id = $transaction_id;
                $manual->devices = $request->input('device');
                $manual->storage = $request->input('storage');
                $manual->storage_validity = $request->input('storage_validity');
                $manual->save();

                session()->flash('success', 'transaction created successfully');
                return redirect()->back();
            } catch (\Exception $e) {
                Log::error('Error creating user: ' . $e->getMessage());
                Session::flash('error', $e->getMessage());
                return redirect()->route('view_client', ['id' => $request->input('client_id')]);
            }
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'An error occurred. Please try again.'])->withInput();
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
}
