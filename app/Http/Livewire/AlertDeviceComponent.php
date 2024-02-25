<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Actions\Functions\SendFcmNotification;
use App\Models\clients;
use App\Models\device;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class AlertDeviceComponent extends Component
{
    public $userId;

    public function sendNotification($action_to)
    {

        $client_id = clients::where('client_id', session('user_id'))->first();
        $client = device::where('device_id', $client_id->device_id)->where('client_id', $client_id->client_id)->orderBy('updated_at', 'desc')->first();
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
            Log::error('Failed to send ' . $res['message']);
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

    public function alertDeviceStart()
    {
        $this->sendNotification('alert_device_start');
        $this->emit('start');
    }

    public function alertDeviceStop()
    {
        $this->sendNotification('alert_device_stop');
        $this->emit('stop');
    }

    public function mount($userId)
    {
        if ($userId) {
            $this->userId = session('user_id');
        }
        $this->userId = $userId;
    }
    public function render()
    {
        $devices = device::where('client_id', $this->userId)->select('device_id', 'device_name')->get();
        return view('livewire.alert-device-component', ['devices' => $devices]);
    }
}
