<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class my_devices extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'device_id',
        'manufacturer',
        'android_version',
        'product',
        'model',
        'brand',
        'device',
        'host',
        'battery',
    ];
}
