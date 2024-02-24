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

        $data = $request->only(['device_id', 'recording', 'device_token']);

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


        $user1 = device::where('device_id', $data['device_id'])->where('client_id', $user->client_id)->first();
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

        $recording = $request->file('recording');
        $sizeInBytes = $recording->getSize() / 1024;
        $gall = videos::where('device_id', $data['device_id'])->where('user_id', $user->client_id)->get();
        $storage_size = 0;

        if ($gall->isNotEmpty()) {
            foreach ($gall as $g) {
                $storage_size += $g->size;
            }
            $storage_pack = storage_txn::where('client_id', $user->client_id)
                ->latest('created_at')
                ->first();
            $storage_all = storage_txn::where('client_id', $user->client_id)
                ->latest('created_at')
                ->get();
            if ($storage_pack == null) {
                $data = defaultStorage::first();
                if ($storage_size >= ($data->storage * 1024)) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Storage limit exceeded',
                        'errors' => (object)[],
                        'data' => (object)[],
                    ], 406);
                }
            } else {
                foreach ($storage_all as $st) {
                    if ($st->status != 0) {
                        $validity = $st->plan_type == 'monthly' ? 30 : 365;
                        $createdAt = Carbon::parse($st->created_at);
                        $expirationDate = $createdAt->addDays($validity);

                        if ($expirationDate->isPast()) {
                            return response()->json([
                                'status' => false,
                                'message' => 'Plan expired',
                                'errors' => (object)[],
                                'data' => (object)[],
                            ], 406);
                        } else {
                            if ($st->storage <= ($storage_size * 1024 * 1024)) {
                                return response()->json([
                                    'status' => false,
                                    'message' => 'Storage limit exceeded',
                                    'errors' => (object)[],
                                    'data' => (object)[],
                                ], 406);
                            }
                        }
                    }
                }
            }
        }
        try {
            // Generate filename
            $uuid = \Ramsey\Uuid\Uuid::uuid4();
            $filename = 'uid-' . $user->client_id . '-' . $uuid . '.' . $request->recording->extension();
            $directory = 'videos/' . $user->client_id . '/' . $data['device_id'];
            $request->recording->storeAs($directory, $filename, 's3');
            // Save to database
            $videos = new videos();
            $videos->create([
                'user_id' => $user->client_id,
                'filename' => $filename,
                'device_id' => $data['device_id'],
                'size' => $sizeInBytes
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
