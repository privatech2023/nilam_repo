<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sim_details extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'device_id',
        'operator',
        'area',
        'strength',
        'phone_number'
    ];
}
