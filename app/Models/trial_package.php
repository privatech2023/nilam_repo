<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trial_package extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'duration_in_days',
        'net_amount',
        'tax',
        'price',
        'is_active',
        'devices',
        'features'
    ];
}
