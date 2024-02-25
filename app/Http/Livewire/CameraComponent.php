<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Actions\Functions\SendFcmNotification;
use App\Models\clients;
use App\Models\device;
use App\Models\images;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CameraComponent extends Component
{
    public $userId;
    public $images;

    public function mount($userId)
    {
        $this->loadImages();
        if ($userId == null) {
            $userId = session('user_id');
        }
        $this->userId = $userId;
    }

    public function loadImages()
    {
        $device = clients::where('client_id', $this->userId)->first();
        if ($device) {
            $this->images = images::where('user_id', $this->userId)
                ->where('device_id', $device->device_id)
                ->latest()
                ->get();
        } else {
            $this->images = [];
        }
    }

    public function sendNotification($action_to)
    {
        $client_id = clients::where('client_id', session('user_id'))->first();
        $device = device::where('device_id', $client_id->device_id)->where('client_id', $client_id->client_id)->orderBy('updated_at', 'desc')->first();
        if ($device == null) {
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'danger',
                'message' => 'No Device token! Please register your device first',
            ]);
            return;
        }
        $data = [
            'device_token' =>  $device->device_token,
            'title' => null,
            'body' => null,
            'action_to' => $action_to,
        ];
        try {
            $sendFcmNotification = new SendFcmNotification();
            $res = $sendFcmNotification->sendNotification($data['device_token'], $data['action_to'], $data['title'], $data['body']);
            Log::error('done ' . $res['message'] . ' notification! - ');
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

    public function render()
    {
        $devices = device::where('client_id', $this->userId)->select('device_id', 'device_name')->get();
        return view('livewire.camera-component', ['devices' => $devices]);
    }

    public function takePicture()
    {
        $this->sendNotification('take_picture');
    }
}
