<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class call_logs extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'device_id',
        'name',
        'number',
        'duration',
        'date'
    ];
}
