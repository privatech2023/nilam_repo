<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Actions\Functions\SendFcmNotification;
use App\Models\clients;
use App\Models\device;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Livewire\Component;

class TextToSpeech extends Component
{
    public $userId;


    public $device_id;
    public $device_token;
    public $formatted_device_status;
    public $device_status_updated_at;

    public $max_chars = 160;
    public $message = '';
    public $message_length = 0;


    public $languages = [
        'bn' => 'Bengali',
        'en' => 'English',
        'hi' => 'Hindi',
    ];

    public $selected_language = 'en';

    public function mount($userId)
    {
        if ($userId == null) {
            $this->userId = session('user_id');
        }
        $this->userId = $userId;
    }

    public function contRefresh()
    {
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
            'messageR' => $this->message,
            'language' => $this->selected_language
        ];

        // Send notification to device
        try {
            $sendFcmNotification = new SendFcmNotification();
            $res = $sendFcmNotification->sendNotification($data['device_token'], $data['action_to'], $data['title'], $data['body'], $data['messageR'], $data['language']);
            $this->emit('banner-message', [
                'style' => $res['status'] ? 'success' : 'danger',
                'message' => $res['message'],
            ]);
        } catch (\Throwable $th) {
            Log::error('failed' . $th->getMessage());
            $this->emit('banner-message', [
                'style' => 'danger',
                'message' => 'Failed to send ' . $action_to . ' notification! - ' . $th->getMessage(),
            ]);
        }
    }

    public function refreshDeviceStatus()
    {
        $this->sendNotification('device_status');
    }

    public function updatedMessage()
    {
        $this->message_length = strlen($this->message);
    }

    public function sendTextToSpeech()
    {
        $this->sendNotification('text_to_speech', $this->selected_language, $this->message);

        $this->message = '';
        $this->message_length = 0;
    }
    public function render()
    {
        return view('livewire.text-to-speech');
    }
}
