<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\clients;
use App\Models\defaultStorage;
use App\Models\device;
use App\Models\storage_txn;
use App\Models\videos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UploadVideoController extends Controller
{
    public function uploadVideo(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'device_id' => 'nullable|string',
            'recording' => 'required|file|mimes:mp4|max:25000',
            'device_token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid request',
                'errors' => $validator->errors(),
                'data' => (object)[],
            ], 400);
        }

        if ($request->has('camera_type')) {
            $cameraType = $request->input('camera_type');
        } else {
            $cameraType = 0;
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
        try {
            // Generate filename
            $uuid = \Ramsey\Uuid\Uuid::uuid4();
            $filename = 'uid-' . $user->client_id . '-' . $uuid . '.' . $request->recording->extension();
            $directory = 'videos/' . $user->client_id . '/' . $device_id;
            $request->recording->storeAs($directory, $filename, 's3');
            // Save to database
            $videos = new videos();
            $videos->create([
                'user_id' => $user->client_id,
                'filename' => $filename,
                'device_id' => $device_id,
                'size' => $sizeInBytes,
                'cameraType' => $cameraType
            ]);
        } catch (\Throwable $th) {
            Log::error('Error creating user: ' . $th->getMessage());
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

        // Return response
        return response()->json([
            'status' => true,
            'message' => 'Recording uploaded',
            'errors' => (object)[],
            'data' => (object)[],
        ], 200);
    }
}
