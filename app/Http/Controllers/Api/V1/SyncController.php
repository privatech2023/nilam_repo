<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SyncController extends Controller
{
    public function sync(Request $request)
    {
        if (session('auth-key') != $request->header('Authorization')) {
            // Validate the request...
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:clients,email',
                'mobile_number' => 'required|numeric|exists:clients,mobile_number',
                'force_sync' => 'required|boolean',
                'device_id' => 'nullable|string|required_if:force_sync,true',
                'device_token' => 'nullable|string|required_if:force_sync,true',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Sync failed',
                    'errors' => (object)$validator->errors()->toArray(),
                    'data' => (object)[],
                ], 422);
            }

            $data = $request->only(['email', 'mobile_number', 'device_id', 'device_token', 'force_sync']);

            // Check if authenticated user has the same email and mobile number
            $user = clients::where('email', $data['email'])
                ->where('mobile_number', $data['mobile_number'])
                ->firstOrFail();

            // if (Auth::guard('client')->client_id != $user->client_id) {
            //     return response()->json([
            //         'status' => false,
            //         'message' => 'Unauthorized',
            //         'errors' => (object)[
            //             'email' => ['The email and mobile number does not match.'],
            //             'mobile_number' => ['The email and mobile number does not match.'],
            //         ],
            //         'data' => (object)[],
            //     ], 401);
            // }

            // If device_id and device_token are not empty and force_scan is false, then register new device
            if (!$data['force_sync'] && (!empty($user->device_id) || !empty($user->device_token)) && ($user->device_id != $data['device_id'] || $user->device_token != $data['device_token'])) {
                if ($user->device_count < config('devices.max_devices')) {
                    $user->device_id = $user->device_id ? $user->device_id . ',' . $data['device_id'] : $data['device_id'];
                    $user->device_token = $user->device_token ? $user->device_token . ',' . $data['device_token'] : $data['device_token'];
                    $user->device_count += 1;

                    $count = $user->device_count;
                    $user->save();
                    // return response()->json([
                    //     'status' => false,
                    //     'message' => 'Duplicate device',
                    //     'errors' => (object)[],
                    //     'data' => (object)[],
                    // ], 409);

                    return response()->json([
                        'status' => true,
                        'message' => 'Sync successful',
                        'errors' => (object)[],
                        'data' => (object)[
                            'name' => $user->name,
                            'email' => $user->email,
                            'email_verified' => null,
                            'mobile_number' => $user->mobile_number,
                            'mobile_number_verified' => null,
                            'has_active_subscription' => null,
                            'subscribed_upto' => null,
                            'purchase_url' => 'in-app-purchase-url',
                            'device_id' => $data['device_id'],
                            'device_token' => $data['device_token'],
                            'device_count' => $count,
                            'device_count_max' => config('devices.max_devices'),
                        ],
                    ], 200);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Device limit exceeded',
                        'errors' => (object)[],
                        'data' => (object)[],
                    ], 409);
                }
            }
            // If device_id or device_token are empty or force_scan is true, then update the device_id and device_token
            if ($data['force_sync'] || empty($user->device_id) || empty($user->device_token)) {
                $user->device_id = $data['device_id'];
                $user->device_token = $data['device_token'];
                $user->device_count = 1;
                $count = $user->device_count;
                $user->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Sync successful',
                    'errors' => (object)[],
                    'data' => (object)[
                        'name' => $user->name,
                        'email' => $user->email,
                        'email_verified' => null,
                        'mobile_number' => $user->mobile_number,
                        'mobile_number_verified' => null,
                        'has_active_subscription' => null,
                        'subscribed_upto' => null,
                        'purchase_url' => 'in-app-purchase-url',
                        'device_id' => $data['device_id'],
                        'device_token' => $data['device_token'],
                        'device_count' => $count,
                        'device_count_max' => config('devices.max_devices'),
                    ],
                ], 200);
            }


            return response()->json([
                'status' => true,
                'message' => 'Sync successful',
                'errors' => (object)[],
                'data' => (object)[
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified' => null,
                    'mobile_number' => $user->mobile_number,
                    'mobile_number_verified' => null,
                    'has_active_subscription' => null,
                    'subscribed_upto' => null,
                    'purchase_url' => 'in-app-purchase-url',
                    'device_id' => $data['device_id'],
                    'device_token' => $data['device_token'],
                    'device_count' => $user->device_count,
                    'device_count_max' => config('devices.max_devices'),
                ],
            ], 200);
        }
    }
}
