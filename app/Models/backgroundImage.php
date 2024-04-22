<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class backgroundImage extends Model
{
    use HasFactory;

    public $fillable = [
        'url'
    ];
}
