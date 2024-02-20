<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class device extends Model
{
    use HasFactory;
    protected $fillable = [
        'device_name',
        'device_id',
        'device_token',
        'client_id',
        'host'
    ];
}
