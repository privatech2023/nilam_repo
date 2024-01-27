<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class issue_token extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'device_id',
        'device_token',
        'client_id',
        'detail',
        'status',
        'start_date',
        'end_date',
    ];
}
