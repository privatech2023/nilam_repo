<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Actions\Functions\SendFcmNotification;
use App\Models\clients;
use App\Models\location;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class LocatePhone extends Component
{
    public $lat;
    public $lng;
    public $userId;
    public $api_key;

    public function mount($userId)
    {
        $device = clients::where('client_id', $userId)->first();
        $latlong = location::where('client_id', $userId)->where('device_id', $device->device_id)->first();
        if ($latlong != null) {
            $this->lat = $latlong->lat;
            $this->lng = $latlong->long;
            $this->userId = $userId;
        }

        $this->userId = $userId;
    }

    public function contRefreshComponentSpecific()
    {
        $device = clients::where('client_id', $this->userId)->first();
        $latlong = location::where('client_id', $this->userId)->where('device_id', $device->device_id)->first();
        if ($latlong != null) {
            $this->lat = $latlong->lat;
            $this->lng = $latlong->long;
        }
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
        ];

        // Send notification to device
        try {
            $sendFcmNotification = new SendFcmNotification();
            $res = $sendFcmNotification->sendNotification($data['device_token'], $data['action_to'], $data['title'], $data['body']);
            $this->dispatchBrowserEvent('banner-message', [
                'style' => $res['status'] ? 'success' : 'danger',
                'message' => $res['message'],
            ]);
        } catch (\Throwable $th) {
            Log::error('not done ' . $res['message'] . ' notification! - ');
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'danger',
                'message' => 'Failed to send ' . $action_to . ' notification! - ' . $th->getMessage(),
            ]);
        }
    }

    public function locatePhone()
    {
        $this->sendNotification('locate_phone');
    }


    public function render()
    {
        return view('livewire.locate-phone');
    }
}
