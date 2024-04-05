<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class upline_earning extends Model
{
    use HasFactory;
    public $fillable = [
        'upline_id',
        'downline_id',
        'amount',
        'status'
    ];
}
