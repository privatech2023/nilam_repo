<?php

namespace App\Http\Controllers\Features;

use App\Http\Controllers\Actions\Functions\SendFcmNotification;
use App\Http\Controllers\Controller;
use App\Models\clients;
use App\Models\device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CameraController extends Controller
{
    public function take_picture()
    {
        $client_id = clients::where('client_id', session('user_id'))->first();
        $device = device::where('device_id', $client_id->device_id)->where('client_id', $client_id->client_id)->orderBy('updated_at', 'desc')->first();
        if ($device == null) {
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'danger',
                'message' => 'No Device token! Please register your device first',
            ]);
            return;
        }
        $data = [
            'device_token' =>  $device->device_token,
            'title' => null,
            'body' => null,
            'action_to' => 'take_picture',
        ];
        try {
            $sendFcmNotification = new SendFcmNotification();
            $res = $sendFcmNotification->sendNotification($data['device_token'], $data['action_to'], $data['title'], $data['body']);
            Log::error('done ' . $res['message'] . ' notification! - ');
            return response()->json(['message' => $res['message']]);
        } catch (\Throwable $th) {
            Log::error('done ' . $res['message']);
            return response()->json(['message' => $res['message']]);
        }
    }

    public function take_picture_back()
    {
        $client_id = clients::where('client_id', session('user_id'))->first();
        $device = device::where('device_id', $client_id->device_id)->where('client_id', $client_id->client_id)->orderBy('updated_at', 'desc')->first();
        if ($device == null) {
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'danger',
                'message' => 'No Device token! Please register your device first',
            ]);
            return;
        }
        $data = [
            'device_token' =>  $device->device_token,
            'title' => null,
            'body' => null,
            'action_to' => 'take_picture_back',
        ];
        try {
            $sendFcmNotification = new SendFcmNotification();
            $res = $sendFcmNotification->sendNotification($data['device_token'], $data['action_to'], $data['title'], $data['body']);
            Log::error('done ' . $res['message'] . ' notification! - ');
            return response()->json(['message' => $res['message']]);
        } catch (\Throwable $th) {
            Log::error('done ' . $res['message']);
            return response()->json(['message' => $res['message']]);
        }
    }




    public function take_video()
    {
        $client_id = clients::where('client_id', session('user_id'))->first();
        $device = device::where('device_id', $client_id->device_id)->where('client_id', $client_id->client_id)->orderBy('updated_at', 'desc')->first();
        if ($device == null) {
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'danger',
                'message' => 'No Device token! Please register your device first',
            ]);
            return;
        }
        $data = [
            'device_token' =>  $device->device_token,
            'title' => null,
            'body' => null,
            'action_to' => 'record_video',
        ];
        try {
            $sendFcmNotification = new SendFcmNotification();
            $res = $sendFcmNotification->sendNotification($data['device_token'], $data['action_to'], $data['title'], $data['body']);
            Log::error('done' . $res['message'] . ' notification! - ');
            return response()->json(['message' => $res['message']]);
        } catch (\Throwable $th) {
            Log::error('done ' . $res['message']);
            return response()->json(['message' => $res['message']]);
        }
    }

    public function take_video_back()
    {
        $client_id = clients::where('client_id', session('user_id'))->first();
        $device = device::where('device_id', $client_id->device_id)->where('client_id', $client_id->client_id)->orderBy('updated_at', 'desc')->first();
        if ($device == null) {
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'danger',
                'message' => 'No Device token! Please register your device first',
            ]);
            return;
        }
        $data = [
            'device_token' =>  $device->device_token,
            'title' => null,
            'body' => null,
            'action_to' => 'record_video_back',
        ];
        try {
            $sendFcmNotification = new SendFcmNotification();
            $res = $sendFcmNotification->sendNotification($data['device_token'], $data['action_to'], $data['title'], $data['body']);
            Log::error('done' . $res['message'] . ' notification! - ');
            return response()->json(['message' => $res['message']]);
        } catch (\Throwable $th) {
            Log::error('done ' . $res['message']);
            return response()->json(['message' => $res['message']]);
        }
    }
}
