<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_groups extends Model
{
    use HasFactory;
    protected $table = 'user_groups';

    protected $fillable = [
        'u_id',
        'g_id',
    ];
}
