<?php

namespace App\Http\Livewire;

use App\Models\messages;
use Livewire\Component;

class MessagePopulate extends Component
{
    public $key;
    public $messagesL = [];

    public function mount($key)
    {
        $this->key = $key;
    }


    public function render()
    {
        $message = messages::where('number', $this->key)->get();
        foreach ($message as $msg) {
            $this->messagesL[$msg->message_id] = [
                'body' => $msg->body,
                'is_inbox' => $msg->is_inbox
            ];
        }
        return view('livewire.message-populate');
    }
}
