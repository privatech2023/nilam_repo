<?php

namespace App\Http\Controllers\Features;

use App\Http\Controllers\Actions\Functions\SendFcmNotification;
use App\Http\Controllers\Controller;
use App\Models\clients;
use App\Models\device;
use App\Models\recordings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VoiceRecordController extends Controller
{
    public function get_voice_record($id)
    {
        $client = clients::where('client_id', $id)->first();
        $recording = recordings::where('user_id', $id)->where('device_id', $client->device_id)->get();
        if (!$recording->isEmpty()) {
            return response()->json([
                'status' => 200,
                'recordings' => $recording
            ]);
        } else {
            return response()->json([
                'status' => 400
            ]);
        }
    }

    public function record_voice($id)
    {
        $client_id = clients::where('client_id', $id)->first();
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
            'action_to' => 'record_voice',
        ];
        try {
            $sendFcmNotification = new SendFcmNotification();
            $res = $sendFcmNotification->sendNotification($data['device_token'], $data['action_to'], $data['title'], $data['body']);
            Log::error('done ' . $res['message']);
            return response()->json(['message' => $res['message']]);
        } catch (\Throwable $th) {
            Log::error('Failed to send ' . $data['action_to'] . ' notification! - ' . $th->getMessage());
            return response()->json(['message' => $res['message']]);
        }
    }
}
