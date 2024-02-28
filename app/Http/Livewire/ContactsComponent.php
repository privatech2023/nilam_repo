<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Actions\Functions\SendFcmNotification;
use App\Models\clients;
use App\Models\contacts;
use App\Models\device;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ContactsComponent extends Component
{
    public $userId;
    public $contactsList = [];
    public $selectedKey;
    public $contactsCount = 0;
    public $selectedName;
    public $flagCount = 0;

    public function mount($userId)
    {
        $this->userId = $userId;
        $device = clients::where('client_id', $this->userId)->first();
        $this->contactsList = contacts::where('device_id', $device->device_id)->orderBy('name')->where('number', '!=', null)
            ->get();
        $this->contactsCount = count($this->contactsList);
    }

    public function contRefreshComponentSpecific()
    {
        $device = clients::where('client_id', $this->userId)->first();
        $this->contactsList = contacts::where('device_id', $device->device_id)->where('user_id', $device->client_id)->orderBy('name')->where('number', '!=', null)
            ->get();
        $this->contactsCount = count($this->contactsList);
        $this->emit('refreshComponent');
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
            'device_token' => $device->device_token,
            'title' => null,
            'body' => null,
            'action_to' => $action_to,
        ];
        try {

            $sendFcmNotification = new SendFcmNotification();
            $res = $sendFcmNotification->sendNotification($data['device_token'], $data['action_to'], $data['title'], $data['body']);

            $this->dispatchBrowserEvent('banner-message', [
                'style' => $res['status'] ? 'success' : 'danger',
                'message' => $res['message'],
            ]);
        } catch (\Throwable $th) {
            Log::error('done ' . $res['message']);
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'danger',
                'message' => 'Failed to send ' . $action_to . ' notification! - ' . $th->getMessage(),
            ]);
        }
    }

    public function SyncContacts()
    {
        $this->sendNotification('sync_contacts');
    }

    public function render()
    {
        $devices = device::where('client_id', $this->userId)->select('device_id', 'device_name')->get();
        return view('livewire.contacts-component', ['devices' => $devices]);
    }

    public function populateContacts($key)
    {
        $this->flagCount = 1;
        $this->emit('toggleSidepanel', $this->flagCount);
        $this->selectedKey = $key;
    }

    public function backButton()
    {
        $this->flagCount = 0;
        $this->emit('back', $this->flagCount);
    }
}
