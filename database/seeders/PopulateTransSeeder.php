<?php

namespace Database\Seeders;

use App\Models\transactions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PopulateTransSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transactions = DB::table('transactions')->get();
        foreach ($transactions as $transaction) {
            $paymentId = DB::table('test_subs')
                ->where('payment_id', $transaction->t_id)->first();

            if ($paymentId == null) {
                continue;
            } else {
                $tr = transactions::where('t_id', $transaction->t_id)->first();
                $tr->update([
                    'net_amount' => $paymentId->plan_net_amount,
                    'tax_amt' => $paymentId->plan_tax,
                    'plan_validity_days' => $paymentId->duration_in_days,
                    'package_id' => $paymentId->package_id,
                    'package_name' => $paymentId->package_name,
                    'activation_id' => $paymentId->activation_code_id,
                    'activation_code' => $paymentId->activation_code,
                    'coupon_id' => $paymentId->coupon_id,
                    'coupon_code' => $paymentId->coupon_code,
                    'txn_type' => $paymentId->payment_method,
                    'txn_id' => $transaction->t_id
                ]);
            }
        }
    }
}
