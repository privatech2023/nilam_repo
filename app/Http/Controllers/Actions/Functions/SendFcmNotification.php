<?php

namespace App\Http\Controllers\Actions\Functions;

use Kreait\Firebase\Factory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class SendFcmNotification extends Controller
{
    public function sendNotification($deviceToken = null, $action_to = 'device_status', $title = null, $body = null)
    {

        $firebaseCredentialsPath = base_path($_ENV['FIREBASE_CREDENTIALS'] ?? 'firebase-credentials.json');

        if (!file_exists($firebaseCredentialsPath)) {
            Log::error('Firebase Credentials file not found or not readable.');
        } else {
            $firebase = (new Factory)->withServiceAccount($firebaseCredentialsPath);
        }
        $data = [
            'device_token' => $deviceToken,
            'title' => $title,
            'body' => $body,
            'action_to' => $action_to,
        ];

        try {
            $message = CloudMessage::withTarget('token', $data['device_token'])
                ->withNotification(Notification::create($data['title'], $data['body']))
                ->withData(['action_to' => $data['action_to']])
                ->withAndroidConfig([
                    'priority' => 'high',
                    'direct_boot_ok' => true,
                ]);

            $messaging = $firebase->createMessaging();
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
