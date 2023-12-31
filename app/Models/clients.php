<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class clients extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasApiTokens;
    protected $table = 'clients';

    protected $primaryKey = 'client_id';

    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile_number',
    ];
}
