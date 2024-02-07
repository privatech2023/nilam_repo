<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payments extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'payment_request_id',
        'payment_status',
        'currency',
        'amount_in_cents',
        'fees_in_cents',
        'taxes_in_cents',
        'instrument_type',
        'billing_instrument',
        'failure_reason',
        'failure_message',
        'bank_reference_number',
        'buyer_name',
        'buyer_email',
        'buyer_phone',
        'purpose',
        'shorturl',
        'longurl',
        'mac',
        'redirected',
        'webhook_verified',
        'user_id',
    ];
}
