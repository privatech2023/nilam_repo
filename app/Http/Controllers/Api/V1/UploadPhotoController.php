<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\clients;
use App\Models\images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UploadPhotoController extends Controller
{
    public function uploadPhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'nullable|string',
            'photo' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'device_token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to upload photo',
                'errors' => (object)$validator->errors()->toArray(),
                'data' => (object)[],
            ], 422);
        }

        $data = $request->only(['device_id', 'photo', 'device_token']);


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
        $device_id = $data['device_id'] ?? $user->device_id;

        try {
            // Generate filename
            $uuid = \Ramsey\Uuid\Uuid::uuid4();
            $filename = 'uid-' . $user->client_id . '-' . $uuid . '.' . $request->photo->extension();

            // Upload file to s3 bucket under 'images' folder
            $request->photo->storeAs('images', $filename, 's3');

            // Save to database
            $imagescr = new images();
            $imagescr->create([
                'filename' => $filename,
                'device_id' => $device_id,
                'user_id' => $user->client_id
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
                'message' => 'Failed to upload photo',
                'errors' => $errors,
                'data' => (object)[],
            ], 500);
        }

        // Return response
        return response()->json([
            'status' => true,
            'message' => 'Photo uploaded',
            'errors' => (object)[],
            'data' => (object)[],
        ], 200);
    }
}
