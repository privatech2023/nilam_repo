<?php

namespace App\Http\Controllers\Features;

use App\Http\Controllers\Controller;
use App\Models\backgroundImage;
use App\Models\clients;
use App\Models\gallery_items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BackgroundGalleryController extends Controller
{
    public function index()
    {
        $clients = clients::where('client_id', session('user_id'))->first();
        $gallery_items = gallery_items::where('user_id', session('user_id'))
            ->where('device_id', $clients->device_id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('frontend_new.pages.change-background-gallery')->with(['gallery_items' => $gallery_items]);
    }
    public function set_background(Request $request)
    {
        $user = clients::where('client_id', session('user_id'))->first();
        $data = gallery_items::where('id', $request->input('id'))->first();
        if ($data == null) {
            return redirect()->back();
        }
        $url = Storage::disk('s3')->url('gallery/images/' . $user->client_id . '/' . $user->device_id . '/' . $data->media_url);
        $bg = new backgroundImage();
        $bg->create([
            'url' => $url,
            'client_id' => session('user_id'),
            'is_gallery' => 1
        ]);
        return redirect()->route('home');
    }
}
