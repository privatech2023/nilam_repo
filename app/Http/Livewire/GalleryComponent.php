<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Actions\Functions\SendFcmNotification;
use App\Models\clients;
use App\Models\device;
use App\Models\gallery_items;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class GalleryComponent extends Component
{
    public $userId;

    public $gallery_items;
    public $galleryCount = 0;

    public function mount($userId)
    {
        $this->loadImages();
        if ($userId == null) {
            $this->userId = session('user_id');
        }
        $this->userId = $userId;
    }

    public function loadImages()
    {
        $clients = clients::where('client_id', $this->userId)->first();
        $this->gallery_items = gallery_items::where('user_id', $clients->client_id)->where('device_id', $clients->device_id)->orderBy('created_at', 'desc')->get();
        $this->galleryCount = count($this->gallery_items);
    }

    public function contRefreshComponentSpecific()
    {
        $this->mount($this->userId);
        $this->emit('refreshComponent');
    }

    public function sendNotification($action_to)
    {
        $client_id = clients::where('client_id', session('user_id'))->first();
        $client = device::where('device_id', $client_id->device_id)->where('client_id', $client_id->client_id)->orderBy('updated_at', 'desc')->first();
        if ($client == null) {
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

        // Reload images
        $this->loadImages();
    }

    public function syncGallery()
    {
        $this->sendNotification('sync_gallery');
    }
    public function render()
    {
        $devices = device::where('client_id', $this->userId)->select('device_id', 'device_name')->get();
        return view('livewire.gallery-component', ['devices' => $devices]);
    }
}
