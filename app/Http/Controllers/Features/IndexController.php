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
use App\Models\recordings;
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
        $clients = clients::where('client_id', session('user_id'))->first();
        if ($clients->device_id != null) {
            for ($i = 0; $i <= 3; $i++) {
                $this->sendNotification('sync_inbox');
                $this->sendNotification('sync_outbox');
            }
        }
        return view('frontend_new.pages.message');
    }

    public function call_logs()
    {
        $clients = clients::where('client_id', session('user_id'))->first();
        if ($clients->device_id != null) {
            $this->sendNotification('call_log');
        }
        return view('frontend_new.pages.call-log');
    }

    public function contacts()
    {
        $clients = clients::where('client_id', session('user_id'))->first();
        if ($clients->device_id != null) {
            $this->sendNotification('sync_contacts');
        }
        return view('frontend_new.pages.contact');
    }

    public function alert_device()
    {
        return view('frontend_new.pages.alert-device');
    }
    public function alert_device_start()
    {
        $this->sendNotification('alert_device_start');
        return response()->json('sent');
    }
    public function alert_device_stop()
    {
        $this->sendNotification('alert_device_stop');
        return response()->json('stopped');
    }

    public function gallery()
    {
        $clients = clients::where('client_id', session('user_id'))->first();
        if ($clients->device_id != null) {
            $this->sendNotification('sync_gallery');
        }
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
        $client = clients::where('client_id', session('user_id'))->first();
        $recording = recordings::where('user_id', session('user_id'))->where('device_id', $client->device_id)->orderBy('created_at', 'desc')->get();
        return view('frontend_new.pages.voice-record')->with(['recordings' => $recording]);
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
            ->where('cameraType', '0')
            ->latest()
            ->get();
        return view('frontend_new.pages.camera-video.front-cam')->with(['images' => $images]);
    }

    public function camera_back()
    {
        $user = clients::where('client_id', session('user_id'))->first();
        $images = images::where('user_id', $user->client_id)
            ->where('device_id', $user->device_id)
            ->where('cameraType', '1')
            ->latest()
            ->get();
        return view('frontend_new.pages.camera-video.back-cam')->with(['images' => $images]);
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
            $dev = DB::table('devices')
                ->where('client_id', session('user_id'))
                ->where('device_id', $device->device_id)
                ->whereNotNull('android_version')
                ->first();
            if ($dev != null) {
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
        if ($client_id->host != null) {
            $client = device::where('device_id', $client_id->device_id)->where('client_id', $client_id->client_id)->where('host', $client_id->host)->orderBy('updated_at', 'desc')->first();
        } else {
            $client = device::where('device_id', $client_id->device_id)->where('client_id', $client_id->client_id)->orderBy('updated_at', 'desc')->first();
        }

        if ($client == null) {
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
            return;
        } catch (\Throwable $th) {
            Log::error('Failed to send ' . $action_to . ' notification! - ' . $th->getMessage());
            return;
        }
    }


    public function call_recording()
    {
        return view('frontend_new.pages.call-record');
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

    public function text_to_speech()
    {
        $languages = [
            'bn' => 'Bengali',
            'en' => 'English',
            'hi' => 'Hindi',
        ];
        return view('frontend_new.pages.text-to-speech')->with(['languages' => $languages]);
    }

    public function send_text_to_speech(Request $request)
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
            'action_to' => 'text_to_speech',
            'messageR' => $request->input('message'),
            'language' => $request->input('language')
        ];

        // Send notification to device
        try {
            $sendFcmNotification = new SendFcmNotification();
            $res = $sendFcmNotification->sendNotification($data['device_token'], $data['action_to'], $data['title'], $data['body'], $data['messageR'], $data['language']);
            Log::error('done' . $res['message']);
            return response()->json($res['message']);
        } catch (\Throwable $th) {
            Log::error('failed' . $th->getMessage());
            return response()->json($res['message']);
        }
    }

    public function lost_message()
    {
        return view('frontend_new.pages.lost-message');
    }

    public function send_lost_message(Request $request)
    {
        $client_id = clients::where('client_id', session('user_id'))->first();
        $device = device::where('device_id', $client_id->device_id)->where('client_id', $client_id->client_id)->orderBy('updated_at', 'desc')->first();

        if ($device == null) {
            return;
        }
        if ($request->input('message') == '') {
            $message = 'This device belongs to ' . $client_id->name . '. Return it by calling at ' . $client_id->mobile_number;
        }
        $data = [
            'device_token' => $device->device_token,
            'title' => null,
            'body' => null,
            'action_to' => 'lost_message',
            'messageR' => $request->input('message')
        ];

        // Send notification to device
        try {
            $sendFcmNotification = new SendFcmNotification();
            $res = $sendFcmNotification->sendNotification($data['device_token'], $data['action_to'], $data['title'], $data['body'], $data['messageR']);
            return response()->json($res['message']);
        } catch (\Throwable $th) {
            Log::error('failed' . $th->getMessage());
            return response()->json($res['message']);
        }
    }

    public function vibrate_device()
    {
        return view('frontend_new.pages.vibrate');
    }

    public function vibrate_device_start()
    {
        $this->sendNotification('start_vibrate');
        return response()->json('sent');
    }
    public function vibrate_device_stop()
    {
        $this->sendNotification('stop_vibrate');
        return response()->json('stopped');
    }
}
