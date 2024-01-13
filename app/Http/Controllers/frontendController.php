<?php

namespace App\Http\Controllers;

use App\Models\settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class frontendController extends Controller
{


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

        // $email->setSubject("Login OTP - Privatech");

        // Using a custom template
        $data =  array("otp" => $totp);

        try {
            Mail::to($address)
                ->send(new \App\Mail\OtpMail($data));

            // Email sent successfully
            // You can add your success response or any other logic here
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
}
