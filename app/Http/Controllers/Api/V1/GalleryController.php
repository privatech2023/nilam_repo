<?php


namespace App\Http\Controllers\Api\V1;





use App\Http\Controllers\Controller;
use App\Models\clients;
use App\Models\defaultStorage;
use App\Models\device;
use App\Models\gallery_items;
use App\Models\manual_txns;
use App\Models\storage_txn;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
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
        $user1_auth = clients::where('auth_token', 'LIKE', "%$token%")->first();
        if ($user1_auth == null) {
            return response()->json([
                'status' => false,
                'message' => 'Authorization failed',
                'errors' => (object)[],
                'data' => (object)[],
            ]);
        }
        // Get user
        $user = clients::where('device_id', $data['device_id'])->first();
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
        Log::error('heyyyy');
        $device_id = $data['device_id'];
        try {
            $query = gallery_items::where('user_id', $user->client_id)
                ->select('device_id', 'device_gallery_id', 'media_url', 'media_type', 'created_at');
            $query->where('device_id', $device_id);
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

    public function uploadPhoto2(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required',
            'photo_id' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:300000',
            'device_token' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Failed to upload photo',
                    'errors' => (object) $validator->errors()->toArray(),
                    'data' => (object)[
                        'upload_next' => false
                    ],
                ],
                422,
            );
        }
        $data = $request->only(['device_id', 'photo', 'device_token']);
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        $user = clients::where('auth_token', 'LIKE', "%$token%")->first();
        if ($user == null) {
            return response()->json([
                'status' => false,
                'message' => 'Authorization failed',
                'errors' => (object)[],
                'data' => (object)[
                    'upload_next' => false
                ],
            ], 401);
        }
        $device_id = $data['device_id'];
        $photo = $request->file('photo');
        $sizeInBytes = $photo->getSize();
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
        $gall = gallery_items::where('user_id', $user->client_id)->get();
        $storage_size = 0;
        $storage_pack = storage_txn::where('client_id', $user->client_id)
            ->latest('created_at')
            ->first();
        $storage_txn = storage_txn::where('client_id', $user->client_id)
            ->latest('created_at')
            ->get();

        $storageType = 1;
        $gall_id = 0;
        $storage_ok = false;
        if ($gall->isNotEmpty()) {
            foreach ($gall as $g) {
                $storage_size += $g->size;
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
                        try {
                            $exists = gallery_items::where('device_gallery_id', $request->photo_id)
                                ->where('device_id', $device_id)
                                ->where('user_id', $user->client_id)
                                ->exists();
                            if ($exists) {
                                $model = gallery_items::where('device_gallery_id', $request->photo_id)
                                    ->where('device_id', $device_id)
                                    ->where('user_id', $user->client_id)
                                    ->first();
                                $exists2 = Storage::disk('s3')->exists('gallery/images/' . $user->client_id . '/' . $device_id . '/' . $model->media_url);
                                if ($exists2) {
                                    Storage::disk('s3')->delete('gallery/images/' . $user->client_id . '/' . $device_id . '/' . $model->media_url);
                                }
                                $model->delete();
                            }
                            $uuid = \Ramsey\Uuid\Uuid::uuid4();
                            $filename = 'uid-' . $user->client_id . '-' . $uuid . '-' . $request->photo_id .  '.' . $request->photo->extension();
                            $directory = 'gallery/images/' . $user->client_id . '/' . $device_id;
                            $thumbnail_directory = 'gallery/images/' . $user->client_id . '/' . 'thumbnails' . '/' . $device_id;
                            $request->photo->storeAs($thumbnail_directory, $filename, 's3');
                            $request->photo->storeAs($directory, $filename, 's3');
                            gallery_items::create([
                                'device_gallery_id' => $request->photo_id,
                                'device_id' => $device_id,
                                'user_id' => $user->client_id,
                                'media_type' => 'image',
                                'size' => $sizeInBytes,
                                'media_url' => $filename,
                            ]);
                            $gall2 = gallery_items::where('user_id', $user->client_id)->get();
                            $storage_size2 = 0;
                            foreach ($gall2 as $g) {
                                $storage_size2 += $g->size;
                            }
                            $remaining = ($manual->storage * (1024 * 1024 * 1024)) - $storage_size2;
                            if ($remaining > 0) {
                                return response()->json([
                                    'status' => false,
                                    'message' => 'Device gallery upload successful',
                                    'errors' => (object)[],
                                    'data' => (object)[
                                        'upload_next' => true,
                                        'size' => $remaining
                                    ],
                                ], 200);
                            } else {
                                return response()->json([
                                    'status' => false,
                                    'message' => 'Device gallery upload successful',
                                    'errors' => (object)[],
                                    'data' => (object)[
                                        'upload_next' => false
                                    ],
                                ], 200);
                            }
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
                                    'data' => (object) [
                                        'upload_next' => false
                                    ],
                                ],
                                500,
                            );
                        }
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
                    try {
                        $exists = gallery_items::where('device_gallery_id', $request->photo_id)
                            ->where('device_id', $device_id)
                            ->where('user_id', $user->client_id)
                            ->exists();
                        Log::error('in exists');
                        if ($exists) {
                            $model = gallery_items::where('device_gallery_id', $request->photo_id)
                                ->where('device_id', $device_id)
                                ->where('user_id', $user->client_id)
                                ->first();
                            $exists2 = Storage::disk('s3')->exists('gallery/images/' . $user->client_id . '/' . $device_id . '/' . $model->media_url);
                            if ($exists2) {
                                Storage::disk('s3')->delete('gallery/images/' . $user->client_id . '/' . $device_id . '/' . $model->media_url);
                                Log::error('deleted from s3 1');
                            }
                            $model->delete();
                            Log::error('deleted from model 1');
                        }
                        $uuid = \Ramsey\Uuid\Uuid::uuid4();
                        $filename = 'uid-' . $user->client_id . '-' . $uuid . '-' . $request->photo_id .  '.' . $request->photo->extension();
                        $directory = 'gallery/images/' . $user->client_id . '/' . $device_id;
                        $request->photo->storeAs($directory, $filename, 's3');
                        gallery_items::create([
                            'device_gallery_id' => $request->photo_id,
                            'device_id' => $device_id,
                            'user_id' => $user->client_id,
                            'media_type' => 'image',
                            'size' => $sizeInBytes,
                            'media_url' => $filename,
                        ]);
                        $gall2 = gallery_items::where('user_id', $user->client_id)->get();
                        $storage_size2 = 0;
                        foreach ($gall2 as $g) {
                            $storage_size2 += $g->size;
                        }
                        $remaining = ($data->storage * 1024 * 1024) - $storage_size2;
                        if ($remaining > 0) {
                            return response()->json([
                                'status' => false,
                                'message' => 'Device gallery upload successful',
                                'errors' => (object)[],
                                'data' => (object)[
                                    'upload_next' => true,
                                    'size' => $remaining
                                ],
                            ], 200);
                        } else {
                            return response()->json([
                                'status' => false,
                                'message' => 'Device gallery upload successful',
                                'errors' => (object)[],
                                'data' => (object)[
                                    'upload_next' => false
                                ],
                            ], 200);
                        }
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
                                'data' => (object) [
                                    'upload_next' => false
                                ],
                            ],
                            500,
                        );
                    }
                }
            } else {
                $storageType = 2;
                $c = 1;
                $length_storage = $storage_txn->count();
                foreach ($storage_txn as $st) {
                    if ($st->status != 0) {
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
                                try {
                                    $exists = gallery_items::where('device_gallery_id', $request->photo_id)
                                        ->where('device_id', $device_id)
                                        ->where('user_id', $user->client_id)
                                        ->exists();
                                    if ($exists) {
                                        try {
                                            $model = gallery_items::where('device_gallery_id', $request->photo_id)
                                                ->where('device_id', $device_id)
                                                ->where('user_id', $user->client_id)
                                                ->first();
                                            $exists2 = Storage::disk('s3')->exists('gallery/images/' . $user->client_id . '/' . $device_id . '/' . $model->media_url);
                                            if ($exists2) {
                                                Storage::disk('s3')->delete('gallery/images/' . $user->client_id . '/' . $device_id . '/' . $model->media_url);
                                                Log::error('deleted from s3 2');
                                            }
                                            $model->delete();
                                            Log::error('deleted from model 2');
                                        } catch (\Throwable $th) {
                                            Log::error('Error creating device: ' . $th->getMessage());
                                        }
                                    }
                                    $uuid = \Ramsey\Uuid\Uuid::uuid4();
                                    $filename = 'uid-' . $user->client_id . '-' . $uuid . '-' . $request->photo_id .  '.' . $request->photo->extension();
                                    $directory = 'gallery/images/' . $user->client_id . '/' . $device_id;
                                    $request->photo->storeAs($directory, $filename, 's3');
                                    gallery_items::create([
                                        'device_gallery_id' => $request->photo_id,
                                        'device_id' => $device_id,
                                        'user_id' => $user->client_id,
                                        'media_type' => 'image',
                                        'size' => $sizeInBytes,
                                        'media_url' => $filename,
                                    ]);
                                    $gall2 = gallery_items::where('user_id', $user->client_id)->get();
                                    $storage_size2 = 0;
                                    foreach ($gall2 as $g) {
                                        $storage_size2 += $g->size;
                                    }
                                    $storage_all2 = storage_txn::where('client_id', $user->client_id)
                                        ->where('id', $st->id)
                                        ->first();
                                    $remaining = ($storage_all2->storage * (1024 * 1024 * 1024)) - $storage_size2;
                                    if ($remaining > 0) {
                                        return response()->json([
                                            'status' => false,
                                            'message' => 'Device gallery upload successful',
                                            'errors' => (object)[],
                                            'data' => (object)[
                                                'upload_next' => true,
                                                'size' => $remaining
                                            ],
                                        ], 200);
                                    } else {
                                        return response()->json([
                                            'status' => false,
                                            'message' => 'Device gallery upload successful',
                                            'errors' => (object)[],
                                            'data' => (object)[
                                                'upload_next' => false
                                            ],
                                        ], 200);
                                    }
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
                                            'data' => (object) [
                                                'upload_next' => false
                                            ],
                                        ],
                                        500,
                                    );
                                }
                                break;
                            }
                        }
                    } else {
                        continue;
                    }
                }
            }
        } else {
            $exists = gallery_items::where('device_gallery_id', $request->photo_id)
                ->where('device_id', $device_id)
                ->where('user_id', $user->client_id)
                ->exists();
            try {
                if ($exists) {
                    try {
                        $model = gallery_items::where('device_gallery_id', $request->photo_id)
                            ->where('device_id', $device_id)
                            ->where('user_id', $user->client_id)
                            ->first();
                        $exists2 = Storage::disk('s3')->exists('gallery/images/' . $user->client_id . '/' . $device_id . '/' . $model->media_url);
                        if ($exists2) {
                            Storage::disk('s3')->delete('gallery/images/' . $user->client_id . '/' . $device_id . '/' . $model->media_url);
                            Log::error('deleted from s3 3');
                        }
                        $model->delete();
                        Log::error('deleted from model 3');
                    } catch (\Throwable $th) {
                        Log::error('Error creating device: ' . $th->getMessage());
                    }
                }
                $uuid = \Ramsey\Uuid\Uuid::uuid4();
                $filename = 'uid-' . $user->client_id . '-' . $uuid . '-' . $request->photo_id .  '.' . $request->photo->extension();
                $directory = 'gallery/images/' . $user->client_id . '/' . $device_id;
                $request->photo->storeAs($directory, $filename, 's3');
                gallery_items::create([
                    'device_gallery_id' => $request->photo_id,
                    'device_id' => $device_id,
                    'user_id' => $user->client_id,
                    'media_type' => 'image',
                    'size' => $sizeInBytes,
                    'media_url' => $filename,
                ]);

                return response()->json([
                    'status' => false,
                    'message' => 'Device gallery upload successful.',
                    'errors' => (object)[],
                    'data' => (object)[
                        'upload_next' => true
                    ],
                ], 200);
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
                        'data' => (object) [
                            'upload_next' => false
                        ],
                    ],
                    500,
                );
            }
        }
    }
}
