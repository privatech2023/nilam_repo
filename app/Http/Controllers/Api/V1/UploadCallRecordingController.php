<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\call_recording;
use App\Models\clients;
use App\Models\device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UploadCallRecordingController extends Controller
{
    public function uploadRecording(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'nullable|string',
            'recording' => 'required|file|mimes:mp3,wav,ogg,aac|max:25000',
            'device_token' => 'required',
        ]);
        Log::error('In call recording api');
        Log::info('Request data normal recording: ' . $request->file('recording'));
        try {
            if ($validator->fails()) {
                Log::error($validator->errors()->toArray());
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to upload recording',
                    'errors' => (object)$validator->errors()->toArray(),
                    'data' => (object)[],
                ], 422);
            }
            $data = $request->only(['device_id', 'recording', 'device_token']);
            $device_id = $data['device_id'];
            // Get user

            $token = str_replace('Bearer ', '', $request->header('Authorization'));
            $user = clients::where('auth_token', 'LIKE', "%$token%")->first();
            if ($user == null) {
                return response()->json([
                    'status' => false,
                    'message' => 'Authorization failed',
                    'errors' => (object)[],
                    'data' => (object)[],
                ]);
            }
            $user1 = device::where('device_id', $device_id)->where('client_id', $user->client_id)->first();
            if ($user1 == null) {
                return response()->json([
                    'status' => false,
                    'message' => 'No device found',
                    'errors' => (object)[],
                    'data' => (object)[
                        'upload_next' => $device_id
                    ],
                ], 404);
            }

            $recording = $request->file('recording');
            $sizeInBytes = $recording->getSize() / 1024;
        } catch (\Throwable $th) {
            Log::error('Error creating user: ' . $th->getMessage());
        }

        try {
            // Generate filename
            $uuid = \Ramsey\Uuid\Uuid::uuid4();
            $filename = 'uid-' . $user->client_id . '-' . $uuid . '.' . $request->recording->extension();
            $directory = 'call_recordings/' . $user->client_id . '/' . $device_id;
            $request->recording->storeAs($directory, $filename, 's3');
            // Save to database
            $record = new call_recording();
            $record->create([
                'user_id' => $user->client_id,
                'filename' => $filename,
                'device_id' => $device_id,
                'size' => $sizeInBytes,
            ]);
            // Return response
            return response()->json([
                'status' => true,
                'message' => 'Recording uploaded',
                'errors' => (object)[],
                'data' => (object)[],
            ], 200);
        } catch (\Throwable $th) {
            Log::error('Error creating call recording: ' . $th->getMessage());
            $errors = (object)[];
            if (config('app.debug')) {
                $errors = (object)[
                    'exception' => [$th->getMessage()],
                    'trace' => $th->getTrace(),
                ];
            }
            return response()->json([
                'status' => false,
                'message' => 'Failed to upload recording',
                'errors' => $errors,
                'data' => (object)[],
            ], 500);
        }
    }
}
