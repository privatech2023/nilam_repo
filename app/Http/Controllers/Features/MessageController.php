<?php

namespace App\Http\Controllers\Features;

use App\Http\Controllers\Controller;
use App\Models\clients;
use App\Models\messages;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function get_messages($id)
    {
        $device = clients::where('client_id', $id)->first();
        $messages = messages::where('device_id', $device->device_id)->where('user_id', $device->client_id)
            ->orderBy('message_id', 'desc')
            ->get();
        return response()->json($messages);
    }

    public function get_messagesView($id)
    {
        $data = messages::where('number', $id)->get();
        return view('frontend_new.pages.messageInside')->with(['data' => $data, 'number' => $id]);
    }
}
