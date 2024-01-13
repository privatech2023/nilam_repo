<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subscriptions extends Model
{
    use HasFactory;

    protected $primaryKey = 'subs_id';
    protected $fillable = [
        'client_id',
        'txn_id',
        'started_at',
        'ends_on',
        'validity_days',
        'status',
    ];
}
