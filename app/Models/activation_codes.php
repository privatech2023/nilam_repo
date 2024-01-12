<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class activation_codes extends Model
{
    use HasFactory;
    protected $primaryKey = 'c_id';
    protected $fillable = [
        'code',
        'duration_in_days',
        'net_amount',
        'tax',
        'price',
        'is_active',
        'used_by',
        'created_by',
        'expiry_date',
    ];
}
