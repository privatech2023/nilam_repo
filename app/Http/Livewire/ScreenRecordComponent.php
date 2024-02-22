<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Actions\Functions\SendFcmNotification;
use App\Models\clients;
use App\Models\device;
use App\Models\screen_recordings;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ScreenRecordComponent extends Component
{
    public $userId;

    public $screenRecordings;

    public function mount($userId)
    {
        if ($userId == null) {
            $this->userId = session('user_id');
        }
        $this->userId = $userId;
        $this->loadScreenRecordings();
    }

    public function loadScreenRecordings()
    {
        $device = clients::where('client_id', $this->userId)->first();
        if ($device) {
            $this->screenRecordings  = screen_recordings::where('user_id', $this->userId)
                ->where('device_id', $device->device_id)
                ->latest()
                ->get();
        } else {
            $this->screenRecordings = [];
        }
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

    public function contRefreshComponentSpecific()
    {
        $this->mount($this->userId);
        $this->emit('refreshComponent');
    }
    public function recordScreen()
    {
        $this->sendNotification('record_screen');
    }
    public function render()
    {
        $devices = device::where('client_id', $this->userId)->select('device_id', 'device_name')->get();
        return view('livewire.screen-record-component', ['devices' => $devices]);
    }
}
