<?php

namespace App\Http\Livewire;

use App\Actions\Functions\SendFcmNotification;
use App\Models\clients;
use App\Models\device;
use Illuminate\Support\Facades\Log;
use Livewire\Component;


class MessageComponent extends Component
{

    public $userId;
    public $messageId;
    public $message;
    public function mount($userId)
    {
        if ($userId == null) {
            $userId = session('user_id');
        }
        $this->userId = $userId;
        $this->message;
    }

    public function render()
    {
        $devices = device::where('client_id', $this->userId)->select('device_id', 'device_name')->get();
        return view('livewire.message-component', ['devices' => $devices]);
    }

    public function sendNotification($action_to)
    {
        $client = clients::where('client_id', session('user_id'))->select('device_token')->first();
        if ($client->device_token == null) {
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'danger',
                'message' => 'No Device token! Please register your device first',
            ]);
            Log::error(' err done 1 ' . $action_to . ' notification! - ');
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
            Log::error('done ' . $action_to . ' notification! - ');
            $this->dispatchBrowserEvent('banner-message', [
                'style' => $res['status'] ? 'success' : 'danger',
                'message' => $res['message'],
            ]);
        } catch (\Throwable $th) {
            Log::error('Failed to send ' . $action_to . ' notification! - ' . $th->getMessage());
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'danger',
                'message' => 'Failed to send ' . $action_to . ' notification! - ' . $th->getMessage(),
            ]);
        }
    }

    public function syncInbox()
    {
        $this->sendNotification('sync_inbox');
    }
    public function syncOutbox()
    {
        $this->sendNotification('sync_outbox');
    }

    public function populateMessage($messageId)
    {
        $this->message = "clicked";
        $this->messageId = $messageId;
    }
}