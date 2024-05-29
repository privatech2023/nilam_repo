<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class images extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'device_id',
        'filename',
        'size',
        'cameraType'
    ];

    public function s3Url()
    {
        $user = clients::where('client_id', session('user_id'))->first();
        $mins = 5;
        $url = Storage::disk('s3')->temporaryUrl(
            'images/' . $user->client_id . '/' . $user->device_id . '/' . $this->filename,
            now()->addMinutes($mins)
        );
        return $url;
    }

    public function s3Url2($id)
    {
        $mins = 5;
        $gal = images::where('id', $id)->first();
        $cl = clients::where('client_id', $gal->user_id)->first();
        $url = Storage::disk('s3')->temporaryUrl(
            'images/' . $gal->user_id . '/' . $cl->device_id . '/' . $this->filename,
            now()->addMinutes($mins)
        );
        return $url;
    }
}
