<?php

namespace App\Http\Livewire;

use App\Models\device;
use Livewire\Component;

class GalleryComponent extends Component
{
    public $userId;

    public function mount($userId)
    {
        $this->$userId = $userId;
    }
    public function render()
    {
        $devices = device::where('client_id', $this->userId)->select('device_id', 'device_name')->get();
        return view('livewire.gallery-component', ['devices' => $devices]);
    }
}