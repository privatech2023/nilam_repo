<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\clients;
use App\Models\defaultStorage;
use App\Models\device;
use App\Models\images;
use App\Models\storage_txn;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UploadPhotoController extends Controller
{
    public function uploadPhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'nullable|string',
            'photo' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:25000',
            'device_token' => 'required',
            // 'camera_type' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to upload photo',
                'errors' => (object)$validator->errors()->toArray(),
                'data' => (object)[],
            ], 422);
        }


        if ($request->has('camera_type')) {
            $cameraType = $request->input('camera_type');
        } else {
            $cameraType = 0;
        }

        $data = $request->only(['device_id', 'photo', 'device_token']);
        $device_id = $data['device_id'];
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
                    'upload_next' => $data['device_id']
                ],
            ], 404);
        }
        $photo = $request->file('photo');
        $sizeInBytes = $photo->getSize() / 1024;


        try {
            // Generate filename
            $uuid = \Ramsey\Uuid\Uuid::uuid4();
            $filename = 'uid-' . $user->client_id . '-' . $uuid . '.' . $request->photo->extension();
            $directory = 'images/' . $user->client_id . '/' . $device_id;
            $request->photo->storeAs($directory, $filename, 's3');

            if ($data['camera_type']) {
            }
            // Save to database
            $imagescr = new images();
            $imagescr->create([
                'filename' => $filename,
                'device_id' => $device_id,
                'user_id' => $user->client_id,
                'size' => $sizeInBytes,
                'cameraType' => $cameraType
            ]);

            // Return response
            return response()->json([
                'status' => true,
                'message' => 'Photo uploaded',
                'errors' => (object)[],
                'data' => (object)[],
            ], 200);
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
                'message' => 'Failed to upload photo',
                'errors' => $errors,
                'data' => (object)[],
            ], 500);
        }
    }
}
