<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class recordings extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'device_id',
        'file_name',
    ];
}
