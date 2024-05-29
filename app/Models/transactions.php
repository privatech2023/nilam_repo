<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transactions extends Model
{
    use HasFactory;
    protected $primaryKey = 't_id';
    protected $fillable = [
        'txn_id',
        'client_id',
        'txn_type',
        'txn_mode',
        'net_amount',
        'tax_amt',
        'price',
        'discount_amt',
        'paid_amt',
        'plan_validity_days',
        'package_id',
        'package_name',
        'activation_id',
        'activation_code',
        'coupon_code',
        'status',
        'created_by',
        'razorpay_order_id',
        'redirected',
        'razorpay_payment_id',
        'razorpay_signature',
        'storage_id',
        'storage_name',
        'trial_id'
    ];
}
