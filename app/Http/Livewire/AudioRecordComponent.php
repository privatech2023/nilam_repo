<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Actions\Functions\SendFcmNotification;
use App\Models\clients;
use App\Models\device;
use App\Models\recordings;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class AudioRecordComponent extends Component
{
    public $userId;
    public $recordings = [];

    public function mount($userId)
    {
        $this->loadRecordings();
        if ($userId == null) {
            $this->userId = session('user_id');
        }
        $this->userId = $userId;
    }

    public function loadRecordings()
    {
        $client = clients::where('client_id', $this->userId)->first();
        $recording = recordings::where('user_id', $this->userId)->where('device_id', $client->device_id)->latest()->first();
        $this->recordings = $recording;
    }

    public function sendNotification($action_to)
    {
        $client = clients::where('client_id', $this->userId)->first();
        if ($client->device_token == null) {
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'danger',
                'message' => 'No Device token! Please register your device first',
            ]);
        }

        $data = [
            'device_token' => $client->device_token,
            'title' => null,
            'body' => null,
            'action_to' => $action_to,
        ];

        try {
            $sendFcmNotification = new SendFcmNotification();
            $res = $sendFcmNotification->sendNotification($data['device_token'], $data['action_to'], $data['title'], $data['body']);
            Log::error('done ' . $res['message']);
            $this->dispatchBrowserEvent('banner-message', [
                'style' => $res['status'] ? 'success' : 'danger',
                'message' => $res['message'],
            ]);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'danger',
                'message' => 'Failed to send ' . $action_to . ' notification! - ' . $th->getMessage(),
            ]);
        }
    }

    public function recordVoice()
    {
        $this->sendNotification('record_voice');
    }
    public function render()
    {
        $devices = device::where('client_id', $this->userId)->select('device_id', 'device_name')->get();
        return view('livewire.audio-record-component', ['devices' => $devices]);
    }
}
