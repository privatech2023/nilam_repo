<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\clients;
use App\Models\defaultStorage;
use App\Models\images;
use App\Models\storage_txn;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class UploadPhotoController extends Controller
{
    public function uploadPhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'nullable|string',
            'photo' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:25000',
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

        $photo = $request->file('photo');
        $sizeInBytes = $photo->getSize() / 1024;

        $gall = images::where('device_id', $data['device_id'])->where('user_id', $user->client_id)->get();
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





        $device_id = $data['device_id'] ?? $user->device_id;

        try {
            // Generate filename
            $uuid = \Ramsey\Uuid\Uuid::uuid4();
            $filename = 'uid-' . $user->client_id . '-' . $uuid . '.' . $request->photo->extension();

            $directory = 'images/' . $user->client_id . '/' . $user->device_id;
            $request->photo->storeAs($directory, $filename, 's3');

            // Save to database
            $imagescr = new images();
            $imagescr->create([
                'filename' => $filename,
                'device_id' => $device_id,
                'user_id' => $user->client_id,
                'size' => $sizeInBytes,
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
