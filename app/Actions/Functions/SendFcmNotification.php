<?php

namespace App\Actions\Functions;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Illuminate\Routing\Controller;

class SendFcmNotification extends Controller
{
    public function sendNotification($deviceToken = null, $action_to = 'device_status', $title = null, $body = null)
    {
        try {
            $firebase = (new Factory)->withServiceAccount(config('firebase.credentials_file'));
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
                'action_to' => $actionTo,
            ];

            $messaging = $firebase->createMessaging();

            $message = CloudMessage::withTarget('topic', $topic)
                ->withNotification($notification) // optional
                ->withData($data);
            // Send the FCM message
            $messaging->send($message);

            $res = [
                'status' => true,
                'message' => 'Notification sent for: ' . $action_to . '!',
            ];

            return $res;
        } catch (\Throwable $th) {
            $res = [
                'status' => false,
                'message' => 'Failed to send ' . $action_to . ' notification! - ' . $th->getMessage(),
            ];
            return $res;
        }
    }
}
