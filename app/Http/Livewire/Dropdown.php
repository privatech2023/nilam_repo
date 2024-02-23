<?php

namespace App\Http\Livewire;

use App\Models\clients;
use App\Models\device;
use Livewire\Component;

class Dropdown extends Component
{
    public $deviceId;
    public $userId;
    public $devices;
    public $defaultDevice;


    public function mount()
    {
        $this->userId = session('user_id');
    }
    public function render()
    {
        $this->devices = device::where('client_id', $this->userId)->select('device_id', 'device_name', 'device_token', 'host')->get();
        $this->defaultDevice = clients::where('client_id', $this->userId)->first();
        return view('livewire.dropdown')->with(['devices' => $this->devices, 'defaultDevice' => $this->defaultDevice]);
    }
}
