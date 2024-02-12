<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class storage_txn extends Model
{
    use HasFactory;

    public $fillable = [
        'client_id',
        'txn_id',
        'storage',
        'plan_type',
        'status',
        'plan_id'
    ];
}
