<?php

namespace App\Http\Livewire;

use App\Models\device;
use Livewire\Component;

class ContactsComponent extends Component
{
    public $userId;
    public $profile;
    public $profileId;

    public function mount($userId)
    {
        $this->userId = $userId;
    }
    public function render()
    {
        $devices = device::where('client_id', $this->userId)->select('device_id', 'device_name')->get();
        return view('livewire.contacts-component', ['devices' => $devices]);
    }

    public function populateProfile($messageId)
    {
        $this->profile = "sjd";
        $this->profileId = $messageId;
    }
}
