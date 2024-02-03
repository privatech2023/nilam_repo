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

    public function mount($userId)
    {
        $this->userId = $userId;
        $device = clients::where('client_id', $this->userId)->first();
        $contacts = contacts::where('device_id', $device->device_id)->get();
        foreach ($contacts as $ct) {
            if (isset($this->messageList[$ct->number])) {
                $this->contactsList[$ct->number][] = [
                    'name' => $ct->name,
                ];
            } else {
                $this->contactsList[$ct->number] = [
                    [
                        'name' => $ct->name,
                    ]
                ];
            }
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
        try {

            $sendFcmNotification = new SendFcmNotification();
            $res = $sendFcmNotification->sendNotification($data['device_token'], $data['action_to'], $data['title'], $data['body']);

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
        $this->selectedKey = $key;
    }
}
