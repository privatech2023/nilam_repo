<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number', 'txn_id', 'client_id', 'invoice_date', 'total_amount', 'billing_date'
    ];
}
