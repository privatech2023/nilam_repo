<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\clients;
use App\Models\defaultStorage;
use App\Models\device;
use App\Models\images;
use App\Models\manual_txns;
use App\Models\storage_txn;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UploadPhotoController extends Controller
{
    public function uploadPhoto(Request $request)
    {

        Log::error('in camera api');
        $validator = Validator::make($request->all(), [
            'device_id' => 'nullable|string',
            'photo' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:25000',
            'device_token' => 'required',
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

        $vid = images::where('user_id', $user->client_id)->get();
        $storage_size = 0;
        $storage_pack = storage_txn::where('client_id', $user->client_id)
            ->latest('created_at')
            ->first();
        $storage_txn = storage_txn::where('client_id', $user->client_id)
            ->latest('created_at')
            ->get();

        $photo = $request->file('photo');
        $sizeInBytes = $photo->getSize() / 1024;

        try {
            if ($vid->isNotEmpty()) {
                foreach ($vid as $g) {
                    $storage_size += $g->size;
                }
            }
            $manual = manual_txns::where('client_id', $user->client_id)->orderByDesc('updated_at')->first();
            if ($manual != null) {

                $validity = $manual->storage_validity == 'monthly' ? 30 : 365;
                $createdAt = Carbon::parse($manual->created_at);
                $expirationDate = $createdAt->addDays($validity);
                if ($expirationDate->isPast()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Plan expired',
                        'errors' => (object)[],
                        'data' => (object)[
                            'upload_next' => false
                        ],
                    ], 406);
                } else {
                    if (($manual->storage * (1024 * 1024 * 1024)) <= $storage_size) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Storage limit exceeded',
                            'errors' => (object)[],
                            'data' => (object)[
                                'upload_next' => false
                            ],
                        ], 406);
                    } else {
                        // Generate filename
                        $uuid = \Ramsey\Uuid\Uuid::uuid4();
                        $filename = 'uid-' . $user->client_id . '-' . $uuid . '.' . $request->photo->extension();
                        $directory = 'images/' . $user->client_id . '/' . $device_id;
                        $request->photo->storeAs($directory, $filename, 's3');

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
                    }
                }
            } elseif ($storage_pack == null) {

                $data = defaultStorage::first();
                if ($storage_size >= ($data->storage * 1024 * 1024)) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Go premium',
                        'errors' => (object)[],
                        'data' => (object)[
                            'upload_next' => false
                        ],
                    ], 406);
                } else {
                    // Generate filename
                    $uuid = \Ramsey\Uuid\Uuid::uuid4();
                    $filename = 'uid-' . $user->client_id . '-' . $uuid . '.' . $request->photo->extension();
                    $directory = 'images/' . $user->client_id . '/' . $device_id;
                    $request->photo->storeAs($directory, $filename, 's3');


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
                }
            } else {
                foreach ($storage_txn as $st) {
                    if ($st->status != 0) {
                        $cd = 1;
                        $validity = $st->plan_type == 'monthly' ? 30 : 365;
                        $createdAt = Carbon::parse($st->created_at);
                        $expirationDate = $createdAt->addDays($validity);
                        if ($expirationDate->isPast()) {
                            return response()->json([
                                'status' => false,
                                'message' => 'Plan expired',
                                'errors' => (object)[],
                                'data' => (object)[
                                    'upload_next' => false
                                ],
                            ], 406);
                        } else {
                            if (($st->storage * (1024 * 1024 * 1024)) <= $storage_size) {
                                return response()->json([
                                    'status' => false,
                                    'message' => 'Storage limit exceeded',
                                    'errors' => (object)[],
                                    'data' => (object)[
                                        'upload_next' => false
                                    ],
                                ], 406);
                            } else {
                                // Generate filename
                                $uuid = \Ramsey\Uuid\Uuid::uuid4();
                                $filename = 'uid-' . $user->client_id . '-' . $uuid . '.' . $request->photo->extension();
                                $directory = 'images/' . $user->client_id . '/' . $device_id;
                                $request->photo->storeAs($directory, $filename, 's3');

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
                            }
                        }
                    }
                }
            }

            // Generate filename
            $uuid = \Ramsey\Uuid\Uuid::uuid4();
            $filename = 'uid-' . $user->client_id . '-' . $uuid . '.' . $request->photo->extension();
            $directory = 'images/' . $user->client_id . '/' . $device_id;
            $request->photo->storeAs($directory, $filename, 's3');

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
