<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\clients;
use App\Models\gallery_items;
use App\Models\images;
use App\Models\screen_recordings;
use App\Models\videos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class DeleteController extends Controller
{
    public function index()
    {
        return view('client.camera');
    }

    public function destroy_camera(Request $request)
    {
        $image = images::findOrFail($request->input('id'));
        $user = clients::where('client_id', session('user_id'))->first();
        $s3Path = 'images/' . $user->client_id . '/' . $user->device_id . '/' . $image->filename;
        Storage::disk('s3')->delete($s3Path);
        $image->delete();
        session()->flash('success', 'Image deleted successfully');
        return redirect()->route('camera', ['userId' => Session('user_id')]);
    }

    public function destroy_gallery(Request $request)
    {
        $gall = gallery_items::findOrFail($request->input('id'));
        $user = clients::where('client_id', session('user_id'))->first();
        $s3Path = 'gallery/images/' . $user->client_id . '/' . $user->device_id . '/' . $gall->media_url;
        Storage::disk('s3')->delete($s3Path);
        $gall->delete();
        session()->flash('success', 'Image deleted successfully');
        return redirect()->route('gallery', ['userId' => Session('user_id')]);
    }

    public function destroy_video(Request $request)
    {
        $image = videos::findOrFail($request->input('id'));
        $user = clients::where('client_id', session('user_id'))->first();
        $s3Path = 'videos/' . $user->client_id . '/' . $user->device_id . '/' . $image->filename;
        Storage::disk('s3')->delete($s3Path);
        $image->delete();
        session()->flash('success', 'Image deleted successfully');
        return redirect()->route('video', ['userId' => Session('user_id')]);
    }

    public function destroy_screen_recording(Request $request)
    {
        $image = screen_recordings::findOrFail($request->input('id'));
        $user = clients::where('client_id', session('user_id'))->first();
        $s3Path = 'screen-recordings/' . $user->client_id . '/' . $user->device_id . '/' . $image->filename;
        Storage::disk('s3')->delete($s3Path);
        $image->delete();
        session()->flash('success', 'Image deleted successfully');
        return redirect()->route('screen-record', ['userId' => Session('user_id')]);
    }
}
