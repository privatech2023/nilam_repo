<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class videos extends Model
{
    use HasFactory;
    public $fillable = [
        'user_id',
        'device_id',
        'filename',
        'size'
    ];

    public function s3Url()
    {
        $user = clients::where('client_id', session('user_id'))->first();
        $mins = 5;
        $url = Storage::disk('s3')->temporaryUrl(
            'videos/' . $user->client_id . '/' . $user->device_id . '/' . $this->filename,
            now()->addMinutes($mins)
        );
        return $url;
    }
}
