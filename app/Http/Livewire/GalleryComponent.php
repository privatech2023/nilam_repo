<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Actions\Functions\SendFcmNotification;
use App\Models\clients;
use App\Models\defaultStorage;
use App\Models\device;
use App\Models\gallery_items;
use App\Models\manual_txns;
use App\Models\storage_txn;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Component;



class GalleryComponent extends Component
{
    public $userId;

    public $gallery_items;
    public $galleryCount = 0;

    public $store_more = true;
    public $plan_expired = false;
    public $start = 12;
    public $skip;

    public function mount($userId)
    {
        $this->loadImages();
        $this->storage_count();
        if ($userId == null) {
            $this->userId = session('user_id');
        }
        $this->userId = $userId;
    }

    public function loadImages()
    {
        $clients = clients::where('client_id', $this->userId)->first();
        if (session()->has('current_image_count') && session('current_image_count') > 0) {
            $this->gallery_items = gallery_items::where('user_id', $clients->client_id)
                ->where('device_id', $clients->device_id)
                ->orderBy('created_at', 'desc')
                ->get();

            // ->skip(0)
            // ->take(session('current_image_count'))

            $this->galleryCount = count($this->gallery_items);
        } else {
            $this->gallery_items = gallery_items::where('user_id', $clients->client_id)
                ->where('device_id', $clients->device_id)
                ->orderBy('created_at', 'desc')
                ->get();

            // ->skip(0)
            //->take($this->start)


            $this->galleryCount = count($this->gallery_items);
        }
    }

    public function loadMore()
    {
        // $this->start += 12;
        // Session::put('current_image_count', $this->start);
        $this->mount($this->userId);
        $this->emit('loadmore');
    }

    public function contRefreshComponentSpecific()
    {
        $this->mount($this->userId);
        $this->emit('refreshComponent');
    }

    public function sendNotification($action_to)
    {
        $client_id = clients::where('client_id', session('user_id'))->first();
        $client = device::where('device_id', $client_id->device_id)->where('client_id', $client_id->client_id)->orderBy('updated_at', 'desc')->first();
        if ($client == null) {
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'danger',
                'message' => 'No Device token! Please register your device first',
            ]);
            return;
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
            Log::error('done ' . $res['message']);
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'danger',
                'message' => 'Failed to send ' . $action_to . ' notification! - ' . $th->getMessage(),
            ]);
        }
    }

    public function syncGallery()
    {
        $this->sendNotification('sync_gallery');
        sleep(4);
    }
    public function render()
    {
        $devices = device::where('client_id', $this->userId)->select('device_id', 'device_name')->get();
        return view('livewire.gallery-component', ['devices' => $devices]);
    }

    public function storage_count()
    {
        $gall = gallery_items::where('user_id', $this->userId)->get();
        $storage_size = 0;
        $storage_pack = storage_txn::where('client_id', $this->userId)
            ->latest('created_at')
            ->first();
        $storage_txn = storage_txn::where('client_id', $this->userId)
            ->latest('created_at')
            ->get();

        $cd = 0;
        $manual = manual_txns::where('client_id', $this->userId)->orderByDesc('updated_at')->first();
        if ($manual != null) {
            if ($gall->isNotEmpty()) {
                foreach ($gall as $g) {
                    $storage_size += $g->size;
                }
                $validity = $manual->storage_validity == 'monthly' ? 30 : 365;
                $createdAt = Carbon::parse($manual->created_at);
                $expirationDate = $createdAt->addDays($validity);
                if ($expirationDate->isPast()) {
                    $this->plan_expired = true;
                    return;
                } elseif (($manual->storage * (1024 * 1024 * 1024)) <= $storage_size) {
                    $this->store_more = false;
                    return;
                } else {
                    $this->store_more = true;
                    return;
                }
            } else {
                return;
            }
        } elseif ($gall->isNotEmpty()) {
            foreach ($gall as $g) {
                $storage_size += $g->size;
            }
            if ($storage_pack == null) {
                $data = defaultStorage::first();
                if ($storage_size >= ($data->storage * 1024 * 1024)) {
                    $this->store_more = false;
                    return;
                } else {
                    $this->store_more = true;
                    return;
                }
            } else {
                foreach ($storage_txn as $st) {
                    if ($st->status != 0) {
                        $cd = 1;
                        $validity = $st->plan_type == 'monthly' ? 30 : 365;
                        $createdAt = Carbon::parse($st->created_at);
                        $expirationDate = $createdAt->addDays($validity);
                        if ($expirationDate->isPast()) {
                            $this->plan_expired = true;
                            return;
                        } else {
                            if (($st->storage * (1024 * 1024 * 1024)) <= $storage_size) {
                                $this->store_more = false;
                                return;
                            } else {
                                $this->store_more = true;
                                return;
                            }
                        }
                    } else {
                        continue;
                    }
                }
                // if storage_txn status is all pending
                if ($cd == 0) {
                    $data = defaultStorage::first();
                    if ($storage_size >= ($data->storage * 1024 * 1024)) {
                        $this->store_more = false;
                        return;
                    } else {
                        $this->store_more = true;
                        return;
                    }
                }
            }
        } else {
            return;
        }
    }
}
