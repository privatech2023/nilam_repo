<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class recordings extends Model
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
        $mins = 5;
        $user = clients::where('client_id', session('user_id'))->first();
        $url = Storage::disk('s3')->temporaryUrl(
            'recordings/' . $user->name . '/' . $user->device_id . $this->filename,
            now()->addMinutes($mins)
        );
        return $url;
    }
}
