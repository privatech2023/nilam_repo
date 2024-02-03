<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Actions\Functions\SendFcmNotification;
use App\Models\clients;
use App\Models\device;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class VibrateComponent extends Component
{
    public $userId;


    public function mount($userId)
    {
        if ($userId == null) {
            $this->userId = session('user_id');
        }
        $this->userId = $userId;
    }
    public function sendNotification($action_to)
    {
        // If device token is empty
        $client = clients::where('client_id', session('user_id'))->select('device_token')->first();
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

    public function startVibrate()
    {
        $this->sendNotification('start_vibrate');
    }

    public function stopVibrate()
    {
        $this->sendNotification('stop_vibrate');
    }
    public function render()
    {
        $devices = device::where('client_id', $this->userId)->select('device_id', 'device_name')->get();
        return view('livewire.vibrate-component', ['devices' => $devices]);
    }
}
