<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class screen_recordings extends Model
{
    use HasFactory;
    public $fillable = [
        'user_id',
        'device_id',
        'filename'
    ];
}
