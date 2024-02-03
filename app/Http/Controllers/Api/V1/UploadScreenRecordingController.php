<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\clients;
use App\Models\screen_recordings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UploadScreenRecordingController extends Controller
{
    public function uploadScreenRecording(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'nullable|string',
            'recording' => 'required|file|mimes:mp4,mov,ogg,qt|max:15000',
            'device_token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to upload screen recording',
                'errors' => (object)$validator->errors()->toArray(),
                'data' => (object)[],
            ], 422);
        }

        $data = $request->only(['device_id', 'recording', 'device_token']);

        // Get user

        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        $user1 = clients::where('auth_token', 'LIKE', "%$token%")->first();
        if ($user1 == null) {
            return response()->json([
                'status' => false,
                'message' => 'Authorization failed',
                'errors' => (object)[],
                'data' => (object)[],
            ]);
        }



        $user = clients::where('device_token', $data['device_token'])->where('device_id', $data['device_id'])->first();


        if ($user == null) {
            return response()->json([
                'status' => false,
                'message' => 'No device found',
                'errors' => (object)[],
                'data' => (object)[],
            ], 406);
        }

        try {
            // Generate filename
            $uuid = \Ramsey\Uuid\Uuid::uuid4();
            $filename = 'uid-' . $user->id . '-' . $uuid . '.' . $request->recording->extension();

            // Upload file to s3 bucket under 'screen-recordings' folder
            $request->recording->storeAs('screen-recordings', $filename, 's3');

            // Save to database
            $screen = new screen_recordings();
            $screen->create([
                'user_id' => $user->client_id,
                'filename' => $filename,
                'device_id' => $user->device_id,
            ]);
        } catch (\Throwable $th) {
            $errors = (object)[];
            if (config('app.debug')) {
                $errors = (object)[
                    'exception' => [$th->getMessage()],
                    'trace' => $th->getTrace(),
                ];
            }
            return response()->json([
                'status' => false,
                'message' => 'Failed to upload screen recording',
                'errors' => $errors,
                'data' => (object)[],
            ], 500);
        }

        // Return response
        return response()->json([
            'status' => true,
            'message' => 'Screen Recording uploaded',
            'errors' => (object)[],
            'data' => (object)[],
        ], 200);
    }
}
