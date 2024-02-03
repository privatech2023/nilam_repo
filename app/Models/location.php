<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class location extends Model
{
    use HasFactory;
    public $fillable = [
        'lat',
        'long',
        'client_id',
        'device_id',
    ];
}
