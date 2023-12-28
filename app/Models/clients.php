<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class clients extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'clients';

    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile_number',
    ];
}
