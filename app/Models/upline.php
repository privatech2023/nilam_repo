<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class upline extends Model
{
    use HasFactory;

    public $fillable = [
        'upline_id',
        'role',
        'users',
        'amount'
    ];
}
