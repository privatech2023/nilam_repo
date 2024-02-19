<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\clients;
use App\Models\defaultStorage;
use App\Models\gallery_items;
use App\Models\storage_txn;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    public function listPhotos(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'nullable',
            'device_token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Device gallery check failed',
                    'errors' => (object) $validator->errors()->toArray(),
                    'data' => (object) [],
                ],
                422,
            );
        }
        $data = $request->only(['device_id', 'device_token']);
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
        // Get user
        $user = clients::where('device_token', $data['device_token'])->where('device_id', $data['device_id'])->first();

        if ($user == null) {
            return response()->json([
                'status' => false,
                'message' => 'No device found',
                'errors' => (object)[],
                'data' => (object)[],
            ], 406);
        }

        $device_id = $data['device_id'];

        try {
            $query = gallery_items::where('user_id', $user->client_id)
                ->select('device_id', 'device_gallery_id', 'media_url', 'media_type', 'created_at');

            if ($device_id) {
                $query->where('device_id', $device_id);
            }

            $photos = $query->get();

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Device gallery check successful',
                    'errors' => (object) [],
                    'data' => $photos,
                ],
                200,
            );
        } catch (\Exception $e) {
            $errors = (object) [];
            if (config('app.debug')) {
                $errors = (object) [
                    'exception' => [$e->getMessage()],
                    'trace' => $e->getTrace(),
                ];
            }

            return response()->json(
                [
                    'status' => false,
                    'message' => 'Failed to check device gallery',
                    'errors' => $errors,
                    'data' => (object) [],
                ],
                500,
            );
        }
    }

    public function uploadPhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required',
            'photo_id' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:25000',
            'overwrite' => 'nullable|boolean',
            'device_token' => 'required'
        ]);



        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Failed to upload photo',
                    'errors' => (object) $validator->errors()->toArray(),
                    'data' => (object) [],
                ],
                422,
            );
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

        $photo = $request->file('photo');
        $sizeInBytes = $photo->getSize() / 1024;
        $user = clients::where('device_token', $data['device_token'])->first();
        if ($user == null) {
            return response()->json([
                'status' => false,
                'message' => 'No device found',
                'errors' => (object)[],
                'data' => (object)[],
            ], 406);
        }

        $gall = gallery_items::where('device_id', $data['device_id'])->where('user_id', $user->client_id)->get();
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



        $device_id = $user->device_id;

        $exists = gallery_items::where('device_gallery_id', $request->photo_id)
            ->where('device_id', $device_id)
            ->where('user_id', $user->client_id)
            ->exists();

        if (!$request->overwrite) {
            if ($exists) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Photo already exists',
                        'errors' => (object) [],
                        'data' => (object) [],
                    ],
                    406,
                );
            }
        }

        if (!$device_id) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'No device found',
                    'errors' => (object) [],
                    'data' => (object) [],
                ],
                406,
            );
        }

        try {
            if ($request->overwrite && $exists) {
                $model = gallery_items::where('device_gallery_id', $request->photo_id)
                    ->where('device_id', $device_id)
                    ->where('user_id', $user->client_id)
                    ->first();

                // Delete from s3 bucket
                $exists = Storage::disk('s3')->exists('gallery/images/' . $user->client_id . '/' . $user->device_id . '/' . $model->media_url);
                if ($exists) {
                    Storage::disk('s3')->delete('gallery/images/' . $user->client_id . '/' . $user->device_id . '/' . $model->media_url);
                }

                // Delete from database
                $model->delete();
            }

            $uuid = \Ramsey\Uuid\Uuid::uuid4();
            $filename = 'uid-' . $user->client_id . '-' . $uuid . '-' . $request->photo_id .  '.' . $request->photo->extension();

            $directory = 'gallery/images/' . $user->client_id . '/' . $user->device_id;
            $path = $request->photo->storeAs($directory, $filename, 's3');

            // Save to database
            $gallery_item = gallery_items::create([
                'device_gallery_id' => $request->photo_id,
                'device_id' => $device_id,
                'user_id' => $user->client_id,
                'media_type' => 'image',
                'size' => $sizeInBytes,
                'media_url' => $filename,
            ]);

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Photo uploaded successfully',
                    'errors' => (object) [],
                    'data' => $gallery_item,
                    'path' => $path,
                ],
                200,
            );
        } catch (\Throwable $th) {
            $errors = (object) [];
            if (config('app.debug')) {
                $errors = (object) [
                    'exception' => [$th->getMessage()],
                    'trace' => $th->getTrace(),
                ];
            }

            return response()->json(
                [
                    'status' => false,
                    'message' => 'Failed to upload photo',
                    'errors' => $errors,
                    'data' => (object) [],
                ],
                500,
            );
        }
    }
}
