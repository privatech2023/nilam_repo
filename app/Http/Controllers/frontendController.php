<?php

namespace App\Http\Controllers;

use App\Models\device;
use App\Models\settings;
use App\Models\subscriptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class frontendController extends Controller
{

    public function home()
    {
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
        }
        Session::forget('user_data');
        return view('frontend/pages/index');
    }

    public function sendOTP($number, $message)
    {
        // Account details
        $apiKey = urlencode(getenv('TL_API_KEY'));

        // Message details
        $numbers = array($number);
        $sender = urlencode(getenv('TL_SENDER'));
        $message = rawurlencode($message);
        $numbers = implode(',', $numbers);


        // Prepare data for POST request
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
}
