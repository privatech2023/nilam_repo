<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Actions\Functions\SendFcmNotification;
use App\Models\clients;
use App\Models\device;
use App\Models\my_devices;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class MyDevices extends Component
{
    public $userId;
    public $deviceList = [];

    public function mount($userId)
    {
        if ($userId == null) {
            $this->userId = session('user_id');
        }
        $this->userId = $userId;
        $device = clients::where('client_id', $this->userId)->first();
        if ($device != null) {
            $dev = DB::table('devices')
                ->where('client_id', $this->userId)
                ->whereNotNull('android_version')
                ->get();
            if ($dev->isNotEmpty()) {
                foreach ($dev as $d) {
                    $this->deviceList[] = [
                        'manufacturer' => $d->manufacturer,
                        'model' => $d->model,
                        'version' => $d->android_version,
                        'host' => $d->host,
                        'battery' => $d->battery,
                        'updated_at' => $d->updated_at,
                    ];
                }
            }
        }
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
            Log::error('done ' . $res['message']);
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


    public function render()
    {
        return view('livewire.my-devices');
    }

    public function sendRefresh()
    {
        $this->sendNotification('device_status');
    }
}
