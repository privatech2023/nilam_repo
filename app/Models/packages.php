<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class packages extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'duration_in_days',
        'net_amount',
        'tax',
        'price',
        'is_active',
        'created_by',
        'devices'
    ];
}
