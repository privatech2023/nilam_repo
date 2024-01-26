<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class messages extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'device_id',
        'message_id',
        'number',
        'date',
        'body',
        'is_inbox',
    ];
}
