<?php

namespace App\Http\Controllers\Actions\Functions;

use Kreait\Firebase\Factory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Kreait\Firebase\Messaging\CloudMessage;

class SendFcmNotification extends Controller
{
    public function sendNotification($deviceToken = null, $action_to = 'device_status', $title = null, $body = null)
    {
        $firebase = (new Factory)->withServiceAccount(base_path($_ENV['FIREBASE_CREDENTIALS']));

        // $response = Http::withOptions([
        //     'verify' => 'C:\xampp\php\cacert.pem', 
        // ])->get('https://example.com');

        // if ($response->successful()) {
        $deviceToken = 'foara0OrT9iTXobyvdK70o:APA91bFIDvimDi_AHc_A0jl5PVzBd3Okkr4XXM8cR-2zE4m4K1PGWvcOuKeCBITYWwdlcS9iL9MX9W3tEoFDGdwcMDVWS2RnOqO5zgGFu8h4pEBbOh6cZbUliVInuLM49Vvh8TfbOIDa';
        $title = "Title";
        $body = "Notification";
        $actionTo = "alert_device_stop";
        $topic = 'news_broadcast';

        $notification = [
            'title' => 'Good Night!',
            'body' => 'Your device is secured',
        ];

        $data = [
            'device_token' => $deviceToken,
            'action_to' => $actionTo,
            'title' => $title,
            'topic' => $topic,
        ];

        $messaging = $firebase->createMessaging();

        $message = CloudMessage::withTarget('token', $data['device_token'])
            ->withNotification($notification) // optional
            ->withData($data);



        // Send the FCM message
        $response = $messaging->send($message);

        dd($response);
        // } else print_r($response->body());
    }
}
