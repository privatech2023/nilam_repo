<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class manual_txns extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'txn_id',
        'devices',
        'storage',
        'storage_validity',
    ];
}
