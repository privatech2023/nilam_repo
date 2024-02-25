<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Actions\Functions\SendFcmNotification;
use App\Models\clients;
use App\Models\device;
use App\Models\messages;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Livewire\Component;


class MessageComponent extends Component
{

    public $userId;
    public $messageId;
    public $messageList = [];
    public $selectedKey;
    public $msgCount = 0;
    protected $flag = false;
    public $flagCount = 0;

    public function mount($userId)
    {
        if ($userId == null) {
            $this->userId = session('user_id');
        }
        $this->userId = $userId;
        $device = clients::where('client_id', $this->userId)->first();
        $messages = messages::where('device_id', $device->device_id)
            ->orderBy('message_id', 'desc')
            ->get();
        $messageList = [];
        foreach ($messages as $msg) {
            $phoneNumber = $msg->number;
            $messageDetails = [
                'message_id' => $msg->message_id,
                'date' => $msg->date,
                'body' => $msg->body,
                'is_inbox' => $msg->is_inbox,
            ];
            if (isset($messageList[$phoneNumber])) {
                $messageList[$phoneNumber][] = $messageDetails;
            } else {
                $messageList[$phoneNumber] = [$messageDetails];
            }
        }
        $this->messageList = $messageList;
        $this->msgCount = count($this->messageList);
    }

    public function contRefreshComponentSpecific()
    {
        $this->mount($this->userId);
        $this->emit('refreshComponent');
    }

    public function render()
    {
        $devices = device::where('client_id', $this->userId)->select('device_id', 'device_name')->get();
        return view('livewire.message-component', ['devices' => $devices, 'messageList' => $this->messageList]);
    }

    public function sendNotification($action_to)
    {
        $client_id = clients::where('client_id', session('user_id'))->first();
        $client = device::where('device_id', $client_id->device_id)->where('client_id', $client_id->client_id)->orderBy('updated_at', 'desc')->first();
        if ($client->device_token == null) {
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'danger',
                'message' => 'No Device token! Please register your device first',
            ]);
        }

        $data = [
            'device_token' => $client->device_token,
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
            $this->emit('failed');
            Log::error('Failed to send ' . $action_to . ' notification! - ' . $th->getMessage());
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'danger',
                'message' => 'Failed to send ' . $action_to . ' notification! - ' . $th->getMessage(),
            ]);
        }
    }

    public function syncInbox()
    {
        for ($i = 0; $i <= 4; $i++) {
            $this->sendNotification('sync_inbox');
            sleep(2);
            $this->sendNotification('sync_outbox');
        }
    }
    public function syncOutbox()
    {
        for ($i = 0; $i <= 4; $i++) {
            $this->sendNotification('sync_inbox');
            sleep(2);
            $this->sendNotification('sync_outbox');
        }
    }

    public function populateMessage($key)
    {
        $this->flagCount = 1;
        if ($this->flag == false) {
            $this->selectedKey = $key;
            $this->emit('toggleSidepanel', $this->flagCount);
            $this->flag = true;
        } else {
            $this->selectedKey = $key;
            $this->emit('toggleSidepanel', $this->flagCount);
            $this->flag = false;
        }
    }

    public function backButton()
    {
        $this->flagCount = 0;
        $this->emit('back', $this->flagCount);
    }
}
