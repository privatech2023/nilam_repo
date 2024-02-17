<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Actions\Functions\SendFcmNotification;
use App\Models\clients;
use App\Models\device;
use App\Models\videos;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class VideoRecordComponent extends Component
{
    public $userId;
    public $videos = [];

    public function mount($userId)
    {
        $this->loadVideos();
        if ($userId == null) {
            $this->userId = session('user_id');
        }
        $this->userId = $userId;
    }

    public function loadVideos()
    {
        $client = clients::where('client_id', $this->userId)->first();
        $recording = videos::where('user_id', $this->userId)->where('device_id', $client->device_id)->latest()->get();
        $this->videos = $recording;
    }

    public function sendNotification($action_to)
    {
        $client = clients::where('client_id', $this->userId)->first();
        if ($client->device_token == null) {
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'danger',
                'message' => 'No Device token! Please register your device first',
            ]);
            return;
        }

        $data = [
            'device_token' => $client->device_token,
            'title' => null,
            'body' => null,
            'action_to' => $action_to,
        ];

        // Send notification to device
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

    public function recordVideo()
    {

        $this->sendNotification('record_video');
        $this->emit('record');
    }
    public function render()
    {
        $devices = device::where('client_id', $this->userId)->select('device_id', 'device_name')->get();
        return view('livewire.video-record-component', ['devices' => $devices]);
    }
}
