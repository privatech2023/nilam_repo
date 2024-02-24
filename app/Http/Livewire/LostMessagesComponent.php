<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Actions\Functions\SendFcmNotification;
use App\Models\clients;
use App\Models\device;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class LostMessagesComponent extends Component
{
    public $userId;
    public $lostMessagesCount = 0;
    protected $listeners = ['lostMessage'];

    public function mount($userId)
    {
        $this->userId = $userId;
    }
    public function sendNotification($action_to, $message)
    {
        $client_id = clients::where('client_id', session('user_id'))->first();
        $device = device::where('device_id', $client_id->device_id)->orderBy('updated_at', 'desc')->first();

        if (empty($device->device_token)) {
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'danger',
                'message' => 'No Device token! Please register your device first',
            ]);
            return;
        }

        if ($message == '') {
            $message = 'This device belongs to ' . $device->name . '. Return it by calling at ' . $device->mobile_number;
        }
        $data = [
            'device_token' => $device->device_token,
            'title' => null,
            'body' => null,
            'action_to' => $action_to,
            'messageR' => $message
        ];

        // Send notification to device
        try {
            $sendFcmNotification = new SendFcmNotification();
            $res = $sendFcmNotification->sendNotification($data['device_token'], $data['action_to'], $data['title'], $data['body'], $data['messageR']);
            $this->emit('banner-message', [
                'style' => $res['status'] ? 'success' : 'danger',
                'message' => $res['message'],
            ]);
        } catch (\Throwable $th) {
            Log::error('failed' . $th->getMessage());
            $this->emit('banner-message', [
                'style' => 'danger',
                'message' => 'Failed to send ' . $action_to . ' notification! - ' . $th->getMessage(),
            ]);
        }
    }

    public function lostMessage($message = null)
    {
        $this->sendNotification('lost_message', $message);
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
