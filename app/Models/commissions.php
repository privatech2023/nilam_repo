<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class commissions extends Model
{
    use HasFactory;

    public $fillable = [
        'group_id',
        'commission'
    ];
}
