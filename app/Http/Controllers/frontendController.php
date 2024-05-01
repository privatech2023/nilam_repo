<?php

namespace App\Http\Controllers;

use App\Models\backgroundImage;
use App\Models\defaultStorage;
use App\Models\device;
use App\Models\gallery_items;
use App\Models\manual_txns;
use App\Models\settings;
use App\Models\storage_txn;
use App\Models\subscriptions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class frontendController extends Controller
{
    public $storage_left = 0;
    public $remaining_days = '';
    public $plan_expired = false;
    public $store_more = true;

    public function home()
    {
        $isGall = 0;
        if (session('user_id') != null) {
            $subs = subscriptions::where('client_id', session('user_id'))
                ->where('status', 1)
                ->orderBy('updated_at', 'desc')
                ->first();
            if ($subs != null) {
                Session::put('validity', $subs->ends_on);
            } else {
                Session::put('validity', null);
            }
            $this->storage_count();

            Session::put('storage_left', $this->storage_left);
            Session::put('remaining_days', $this->remaining_days);
            Session::put('plan_expired', $this->plan_expired);
            Session::put('store_more', $this->store_more);
            // dd(session::all());
            $bg = backgroundImage::where('client_id', session('user_id'))->orderBy('created_at', 'desc')->first();
            $isGall = 1;
            if ($bg == null) {
                $isGall = 0;
                $image = [];
            } else {
                if ($bg->image_id != 0) {
                    $isGall = 2;
                    $image = gallery_items::where('id', $bg->image_id)->first();
                    if ($image == null) {
                        $image = [];
                    }
                } else {
                    $image = [];
                }
            }
        } else {
            $bg = 0;
            $image = [];
        }
        Session::forget('user_data');
        return view('frontend/pages/index')->with(['bg' => $bg, 'isGall' => $isGall, 'image' => $image]);
    }

    public function sendOTP($number, $message)
    {

        $apiKey = urlencode(getenv('TL_API_KEY'));
        $numbers = array($number);
        $sender = urlencode(getenv('TL_SENDER'));
        $message = rawurlencode($message);
        $numbers = implode(',', $numbers);
        $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
        $ch = curl_init('https://api.textlocal.in/send/');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);
        if ($response['status'] == 'success') {
            return true;
        } else {
            return false;
        }
    }

    public function sendEmailOtp($address, $totp)
    {
        $data =  array("otp" => $totp);
        try {
            Mail::to($address)
                ->send(new \App\Mail\OtpMail($data));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function getSettings($key)
    {
        $settingsModel = new settings();
        $setting = $settingsModel->where('key', $key)->first();
        return $setting ? $setting->value : null;
    }

    public function get_devices($id)
    {
        $data = device::where('client_id', $id)->first();
        if ($data == null) {
            $data = 0;
        } else {
            $data = 1;
        }
        return response()->json($data);
    }


    public function storage_count()
    {
        try {
            $gall = gallery_items::where('user_id', session('user_id'))->get();
            $storage_size = 0;
            $storage_pack = storage_txn::where('client_id', session('user_id'))
                ->latest('created_at')
                ->first();
            $storage_txn = storage_txn::where('client_id', session('user_id'))
                ->latest('created_at')
                ->get();
            $manual = manual_txns::where('client_id', session('user_id'))->orderByDesc('updated_at')->first();
            $cd = 0;
            if ($manual != null) {
                $validity = $manual->storage_validity == 'monthly' ? 30 : 365;
                $createdAt = Carbon::parse($manual->created_at);
                $expirationDate = $createdAt->addDays($validity);
                if ($gall->isNotEmpty()) {
                    foreach ($gall as $g) {
                        $storage_size += $g->size;
                    }
                    if ($expirationDate->isPast()) {
                        $this->plan_expired = true;
                        return;
                    } elseif (($manual->storage * (1024 * 1024 * 1024)) <= $storage_size) {
                        $this->store_more = false;
                        return;
                    } else {
                        $this->remaining_days = $expirationDate->diffInDays(Carbon::now());
                        $this->storage_left = intval(($manual->storage * 1024) - ($storage_size / (1024 * 1024)));
                        return;
                    }
                } else {
                    $this->remaining_days = $expirationDate->diffInDays(Carbon::now());
                    $this->storage_left = $manual->storage * 1024;
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
                        $this->remaining_days = 'DEFAULT PACK';
                        $this->storage_left = intval($data->storage - ($storage_size / (1024 * 1024)));
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
                                    $this->storage_left = intval(($st->storage * 1024) - ($storage_size / (1024 * 1024)));
                                    $this->remaining_days = $expirationDate->diffInDays(Carbon::now());
                                    $this->store_more = true;
                                    return;
                                }
                            }
                        } else {
                            continue;
                        }
                    }
                    // if storage_txn status is pending
                    if ($cd == 0) {
                        $data = defaultStorage::first();
                        if ($storage_size >= ($data->storage * 1024 * 1024)) {
                            $this->store_more = false;
                            return;
                        } else {
                            $this->store_more = true;
                            $this->remaining_days = 'DEFAULT PACK';
                            $this->storage_left = intval($data->storage - ($storage_size / (1024 * 1024)));
                            return;
                        }
                    }
                }
            } else {
                if ($storage_pack == null) {
                    $data = defaultStorage::first();
                    $this->store_more = true;
                    $this->remaining_days = 'DEFAULT PACK';
                    $this->storage_left = $data->storage;
                    return;
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
                                $this->storage_left = intval($st->storage * 1024);
                                $this->remaining_days = $expirationDate->diffInDays(Carbon::now());
                                $this->store_more = true;
                                return;
                            }
                        } else {
                            continue;
                        }
                    }
                    if ($cd == 0) {
                        $data = defaultStorage::first();
                        $this->store_more = true;
                        $this->remaining_days = 'DEFAULT PACK';
                        $this->storage_left = $data->storage;
                        return;
                    }
                }
                return;
            }
        } catch (\Exception $e) {
            Log::error('error main: ' . $e->getMessage());
        }
    }


    public function session_data()
    {
        $data = Session::all();
        return response()->json('hey');
    }
}
