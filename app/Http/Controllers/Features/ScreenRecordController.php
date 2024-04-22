<?php

namespace App\Http\Controllers\Features;

use App\Http\Controllers\Actions\Functions\SendFcmNotification;
use App\Http\Controllers\Controller;
use App\Models\clients;
use App\Models\device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ScreenRecordController extends Controller
{
    public function take_screen_record()
    {
        $client_id = clients::where('client_id', session('user_id'))->first();
        $client = device::where('device_id', $client_id->device_id)->where('client_id', $client_id->client_id)->orderBy('updated_at', 'desc')->first();
        if ($client == null) {
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'danger',
                'message' => 'No Device token! Please register your device first',
            ]);
        }

        $data = [
            'device_token' => $client->device_token,
            'title' => null,
            'body' => null,
            'action_to' => 'record_screen',
        ];
        try {
            $sendFcmNotification = new SendFcmNotification();
            $res = $sendFcmNotification->sendNotification($data['device_token'], $data['action_to'], $data['title'], $data['body']);
            Log::error('done ' . $res['message']);
            return response()->json(['message' => $res['message']]);
        } catch (\Throwable $th) {
            Log::error('done ' . $res['message']);
            return response()->json(['message' => $res['message']]);
        }
    }
}
