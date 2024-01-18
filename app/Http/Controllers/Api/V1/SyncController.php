<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\clients;
use App\Models\device;
use App\Models\subscriptions;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

            $data = $request->only(['email', 'mobile_number', 'device_id', 'device_token', 'force_sync', 'client_id', 'device_name']);
            // Check if authenticated user has the same email and mobile number

            $activeSubscriptionEndDate = subscriptions::where('client_id', $data['client_id'])
                ->where('status', 1)
                ->where('ends_on', '>=', date('Y-m-d'))
                ->orderByDesc('ends_on')
                ->value('ends_on');
            $client = clients::where('client_id', $data['client_id'])->first();
            $user = device::where('client_id', $data['client_id'])
                ->first();
            $user_match = device::where('device_token', $data['device_token'])
                ->first();
            $user_count = device::where('client_id', $data['client_id'])->count();

            // If device_id and device_token are not empty and force_scan is false, then register new device
            try {
                if ($data['force_sync'] == false && (!empty($user->device_id) || !empty($user->device_token))) {

                    if ($user_match != null) {
                        $count = $user_count;
                        return response()->json([
                            'status' => true,
                            'message' => 'Sync successful.',
                            'errors' => (object)[],
                            'data' => (object)[
                                'name' => $client->name,
                                'email' => $client->email,
                                'email_verified' => null,
                                'mobile_number' => $client->mobile_number,
                                'mobile_number_verified' =>  null,
                                'has_active_subscription' => $activeSubscriptionEndDate ? true : false,
                                'subscribed_upto' => $activeSubscriptionEndDate,
                                'purchase_url' => 'in-app-purchase-url',
                                'device_id' => $data['device_id'],
                                'device_token' => $data['device_token'],
                                'device_count' => $count,
                                'device_count_max' => config('devices.max_devices'),
                            ],
                        ], 200);
                    }
                    if ($user_count  < config('devices.max_devices')) {
                        $device = new device();
                        $device->device_id = $data['device_id'];
                        $device->device_token = $data['device_token'];
                        $device->device_name = $data['device_name'];
                        $device->client_id = $data['client_id'];

                        $count = $user_count;
                        $device->save();
                        return response()->json([
                            'status' => true,
                            'message' => 'Sync successful',
                            'errors' => (object)[],
                            'data' => (object)[
                                'name' => $client->name,
                                'email' => $client->email,
                                'email_verified' => null,
                                'mobile_number' => $client->mobile_number,
                                'mobile_number_verified' => null,
                                'has_active_subscription' =>  $activeSubscriptionEndDate ?  True : False,
                                'subscribed_upto' =>  $activeSubscriptionEndDate,
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
                if ($data['force_sync'] == true || $user == null) {
                    $device = new device();
                    $device->device_id = $data['device_id'];
                    $device->device_token = $data['device_token'];
                    $device->device_name = $data['device_name'];
                    $device->client_id = $data['client_id'];
                    $device->save();
                    $count = $user_count;

                    return response()->json([
                        'status' => true,
                        'message' => 'Sync successful',
                        'errors' => (object)[],
                        'data' => (object)[
                            'name' => $client->name,
                            'email' => $client->email,
                            'email_verified' => null,
                            'mobile_number' => $client->mobile_number,
                            'mobile_number_verified' => null,
                            'has_active_subscription' => $activeSubscriptionEndDate ?  True : False,
                            'subscribed_upto' => $activeSubscriptionEndDate,
                            'purchase_url' => 'in-app-purchase-url',
                            'device_id' => $data['device_id'],
                            'device_token' => $data['device_token'],
                            'device_count' => $count,
                            'device_count_max' => config('devices.max_devices'),
                        ],
                    ], 200);
                }
            } catch (Exception $e) {
                return response()->json([
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
}
