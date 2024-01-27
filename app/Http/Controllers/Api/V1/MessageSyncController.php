<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\clients;
use App\Models\messages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MessageSyncController extends Controller
{
    public function getLastMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'nullable|string',
            'inbox' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve last message',
                'errors' => (object)$validator->errors()->toArray(),
                'data' => (object)[],
            ], 422);
        }

        $data = $request->only(['device_id', 'inbox']);

        // $user = clients::where('client_id', session('user_id'))->first();
        $user = clients::where('auth_token', $request->header('Authorization'))->where('device_id', $data['device_id'])->first();
        $device_id = $data['device_id'] ?? $user->device_id;
        if ($user == null) {
            return response()->json([
                'status' => false,
                'message' => 'Authorization failed',
                'errors' => (object)[],
                'data' => (object)[],
            ], 406);
        }
        if (!$device_id) {
            return response()->json([
                'status' => false,
                'message' => 'No device ID found',
                'errors' => (object)[],
                'data' => (object)[],
            ], 406);
        }

        $last_message = DB::table('messages')
            ->where('device_id', $device_id)
            ->where('is_inbox', $data['inbox'])
            ->orderBy('message_id', 'desc')
            ->first();

        if (!$last_message) {
            return response()->json([
                'status' => false,
                'message' => 'No messages found',
                'errors' => (object)[],
                'data' => (object)[],
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Last message retrieved',
            'errors' => (object)[],
            'data' => (object)[
                'last_message' => (object)[
                    'message_id' => $last_message->message_id,
                    'device_id' => $last_message->device_id,
                    'number' => $last_message->number,
                    'date' => $last_message->date,
                    'body' => $last_message->body,
                    'is_inbox' => $last_message->is_inbox,
                ]
            ],
        ], 200);
    }


    public function uploadMessages(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'device_id' => 'nullable|string',
            'inbox' => 'required|boolean',
            'json_file' => 'required|file|mimes:json,txt|max:10000',
            'device_token' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to upload messages',
                'errors' => (object)$validator->errors()->toArray(),
                'data' => (object)[],
            ], 422);
        }

        $data = $request->only(['device_id', 'inbox', 'json_file']);

        $user = clients::where('auth_token', $request->header('Authorization'))->where('device_id', $data['device_id'])->first();
        if ($user == null) {
            return response()->json([
                'status' => false,
                'message' => 'Authorization failed',
                'errors' => (object)[],
                'data' => (object)[],
            ]);
        }
        $device_id = $data['device_id'] ?? $user->device_id;

        if (!$device_id) {
            return response()->json([
                'status' => false,
                'message' => 'No device found',
                'errors' => (object)[],
                'data' => (object)[],
            ], 406);
        }
        $json_file = $data['json_file'];
        // Store the file in storage/app/messages/inbox or storage/app/messages/outbox
        $json_file_path = 'messages/' . ($data['inbox'] ? 'inbox' : 'outbox') . '/' . $json_file->getClientOriginalName();
        $json_file->storeAs('messages/' . ($data['inbox'] ? 'inbox' : 'outbox'), $json_file->getClientOriginalName());

        // Read the file contents
        $json_file_content = file_get_contents(storage_path('app/' . $json_file_path));
        $json_file_content = json_decode($json_file_content, true);

        try {
            $messages = $json_file_content['data'];

            $messagesToInsert = [];
            $now = now();

            foreach ($messages as $message) {
                if ((messages::where('message_id', $message['message_id'])->first()) != null) {
                    continue;
                }
                $message['user_id'] = $user->client_id;
                $message['device_id'] = $device_id;
                $message['message_id'] = $message['message_id'];
                $message['number'] = $message['number'];
                $message['date'] = $message['date'];
                $message['body'] = $message['body'];
                $message['is_inbox'] = $data['inbox'];
                $message['created_at'] = $now;
                $message['updated_at'] = $now;
                $messagesToInsert[] = $message;
            }

            foreach (array_chunk($messagesToInsert, 1000) as $chunk) {
                DB::table('messages')->insert($chunk);
            }

            // Delete the file
            unlink(storage_path('app/' . $json_file_path));
        } catch (\Exception $e) {
            // Delete the file
            unlink(storage_path('app/' . $json_file_path));

            $errors = (object)[];
            if (config('app.debug')) {
                $errors = (object)[
                    'exception' => [$e->getMessage()],
                    'trace' => $e->getTrace(),
                ];
            }

            return response()->json([
                'status' => false,
                'message' => 'Failed to upload messages',
                'errors' => $errors,
                'data' => (object)[],
            ], 500);
        }

        return response()->json([
            'status' => true,
            'message' => 'Messages uploaded',
            'errors' => (object)[],
            'data' => (object)[],
        ], 200);
    }
}