<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Actions\Functions\SendFcmNotification;
use App\Models\call_logs;
use App\Models\clients;
use App\Models\device;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CallLogComponent extends Component
{
    public $userId;
    public $callList = [];


    public function mount($userId)
    {
        if ($userId == null) {
            $this->userId = session('user_id');
        } else {
            $this->userId = $userId;
        }
        $user = clients::where('client_id', $this->userId)->first();
        $calls = call_logs::where('user_id', $user->client_id)
            ->where('device_id', $user->device_id)
            ->orderBy('date', 'desc')
            ->paginate(100);
        // dd($calls);
        foreach ($calls as $c) {
            $this->callList[] = [
                'name' => $c->name,
                'number' => $c->number,
                'duration' => $c->duration,
                'date' => $c->date
            ];
        }
        // dd($this->callList);
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
            Log::error('done ' . $res['message'] . ' notification! - ');
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

    public function contRefreshComponentSpecific()
    {
        $this->mount($this->userId);
        $this->emit('refreshComponent');
    }


    public function SyncCallLog()
    {
        $this->sendNotification('call_log');
    }

    public function render()
    {
        $devices = device::where('client_id', $this->userId)->select('device_id', 'device_name')->get();
        return view('livewire.call-log-component', ['devices' => $devices]);
    }

    public function backButton()
    {
        $this->emit('back');
    }
}
