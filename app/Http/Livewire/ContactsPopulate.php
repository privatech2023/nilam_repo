<?php

namespace App\Http\Livewire;

use App\Models\contacts;
use Livewire\Component;

class ContactsPopulate extends Component
{
    public $key;
    public $contactsL = [];
    public function mount($key)
    {
        $this->key = $key;
    }

    public function render()
    {
        $contacts = contacts::where('number', $this->key)->first();
        $this->contactsL[$contacts->number] = $contacts->name;
        return view('livewire.contacts-populate');
    }
}
