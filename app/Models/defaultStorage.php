<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class defaultStorage extends Model
{
    use HasFactory;
    public $fillable = [
        'storage'
    ];
}
