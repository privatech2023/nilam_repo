<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class storage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'storage',
        'plan_validity',
        'amount',
        'tax',
        'price',
        'status',
    ];
}
