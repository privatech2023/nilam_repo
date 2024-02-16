<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tech_tokens extends Model
{
    use HasFactory;
    public $fillable = [
        'token_id',
        'status'
    ];
}
