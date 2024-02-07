<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Actions\Functions\SendFcmNotification;
use App\Models\clients;
use App\Models\device;
use Livewire\Component;

class LostMessagesComponent extends Component
{
    public $userId;
    public $lostMessagesCount = 0;

    public function mount($userId)
    {
        $this->userId = $userId;
    }
    public function sendNotification($action_to)
    {
        $device = clients::where('client_id', $this->userId)->first();

        if (empty($device->device_token)) {
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'danger',
                'message' => 'No Device token! Please register your device first',
            ]);
            return;
        }

        $data = [
            'device_token' => $device->device_token,
            'title' => null,
            'body' => null,
            'action_to' => $action_to,
            'language' => 'English',
            'message' => 'This device belongs to ' . $device->name . 'Return it by calling at ' . $device->mobile_number
        ];

        // Send notification to device
        try {
            $sendFcmNotification = new SendFcmNotification();
            $res = $sendFcmNotification->sendNotification($data['device_token'], $data['action_to'], $data['title'], $data['body'], $data['language'], $data['message']);
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

    public function lostMessage()
    {
        $this->sendNotification('lost_message');
    }

    public function render()
    {
        $devices = device::where('client_id', $this->userId)->select('device_id', 'device_name')->get();
        return view('livewire.lost-messages-component', ['devices' => $devices]);
    }

    public function contRefreshComponentSpecific()
    {
        $this->emit('refreshComponent');
    }
}
