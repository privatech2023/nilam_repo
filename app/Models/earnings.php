<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class earnings extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'commission',
        'client_id',
        'status'
    ];
}
