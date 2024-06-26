<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\activation_codes;
use App\Models\clients;
use App\Models\device;
use App\Models\manual_txns;
use App\Models\packages;
use App\Models\subscriptions;
use App\Models\transactions;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SyncController extends Controller
{
    public function sync(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:clients,email',
            'mobile_number' => 'required|numeric|exists:clients,mobile_number',
            'force_sync' => 'required|boolean',
            'device_id' => 'nullable|string|required_if:force_sync,true',
            'device_token' => 'nullable|string|required_if:force_sync,true',
        ]);

        if ($request->has('device_name')) {
            $device_name = $request->input('device_name');
        } else {
            $device_name = '';
        }
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
                'errors' => (object)$validator->errors()->toArray(),
                'data' => (object)[],
            ], 401);
        }
        $host = '';
        if ($request->has('host')) {
            $host = $request->input('host');
        }
        $data = $request->only(['email', 'mobile_number', 'device_id', 'device_token', 'force_sync']);
        $client = clients::where('email', $data['email'])->where('mobile_number', $data['mobile_number'])->first();

        if ($client == null) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
                'errors' => [
                    'email' => ['The email and mobile number do not match.'],
                    'mobile_number' => ['The email and mobile number do not match.'],
                ],
                'data' => (object)[],
            ], 401);
        }

        $token = str_replace('Bearer ', '', $request->header('Authorization'));

        if (!in_array($token, explode(',', $client->auth_token))) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid token header',
                'errors' => (object)[],
                'data' => (object) [],
            ], 401);
        }

        $client_id = $client->client_id;
        $activeSubscriptionEndDate = subscriptions::where('client_id', $client_id)
            ->where('status', 1)
            ->where('ends_on', '>=', date('Y-m-d'))
            ->orderByDesc('updated_at')
            ->value('ends_on');
        $subs = subscriptions::where('client_id', $client_id)
            ->where('status', 1)
            ->where('ends_on', '>=', date('Y-m-d'))
            ->orderByDesc('updated_at')
            ->first();
        $total_devices = 1;
        if ($subs != null) {
            $txns = transactions::where('txn_id', $subs->txn_id)->first();
            $manual = manual_txns::where('client_id', $client_id)->orderByDesc('updated_at')->first();
            if ($manual != null) {
                $total_devices = $manual->devices;
            } elseif ($txns->activation_id != null) {
                $dv_count = activation_codes::where('c_id', $txns->activation_id)->first();
                $total_devices = $dv_count->devices;
            } elseif ($txns->package_id != null) {
                $dv_count_pack = packages::where('id', $txns->package_id)->first();
                if ($dv_count_pack == null) {
                    $total_devices = 1;
                } else {
                    $total_devices = $dv_count_pack->devices;
                }
            }
        }
        $client = clients::where('client_id', $client_id)->first();
        $user = device::where('client_id', $client_id)
            ->first();
        $user_match = device::where('host', $host)->where('device_id', $data['device_id'])->where('client_id', $client_id)
            ->first();
        $user_count = device::where('client_id', $client_id)->count();

        $device_id = $data['device_id'];
        $dv_token = $data['device_token'];
        try {
            if ($data['force_sync'] == false && (!empty($user->device_id) || !empty($user->device_token))) {
                if ($user_match != null) {
                    $client->device_id = $device_id;
                    $client->host = $host;
                    $client->save();
                    $user_match->device_token = $dv_token;
                    $user_match->device_name = $device_name;
                    $user_match->save();
                    $count = $user_count;
                    Cache::put('sync', true);
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
                            'device_id' => $device_id,
                            'device_host' => $host,
                            'device_token' => $dv_token,
                            'device_count' => $count,
                            'device_count_max' => config('devices.max_devices'),
                        ],
                    ], 200);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'New device',
                        'errors' => (object)[],
                        'data' => (object) [],
                    ], 404);
                }
            } elseif ($data['force_sync'] ==  false && $user == null) {
                return response()->json([
                    'status' => false,
                    'message' => 'New device',
                    'errors' => (object)[],
                    'data' => (object) [],
                ], 404);
            } elseif ($data['force_sync'] == true && (!empty($user->device_id) || !empty($user->device_token))) {
                if ($user_match != null) {
                    $count = $user_count;
                    $client->device_id = $device_id;
                    $client->host = $host;
                    $client->save();

                    $user_match->host = $host;
                    $user_match->device_token = $dv_token;
                    $user_match->device_name = $device_name;
                    $user_match->save();
                    Cache::put('sync', true);
                    return response()->json([
                        'status' => true,
                        'message' => 'Sync successful..',
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
                            'device_id' => $device_id,
                            'device_token' => $dv_token,
                            'device_count' => $count,
                            'device_host' => $host,
                            'device_count_max' => config('devices.max_devices'),
                        ],
                    ], 200);
                } elseif ($user_match == null && $user_count  < $total_devices) {
                    $count = $user_count;
                    $client->device_id = $device_id;
                    $client->host = $host;
                    $client->save();
                    $device = new device();
                    $device->device_id = $device_id;
                    $device->device_token = $dv_token;
                    $device->device_name = $device_name;
                    $device->client_id = $client_id;
                    $device->host = $host;
                    $count = $user_count + 1;
                    $device->save();
                    Cache::put('sync', true);
                    return response()->json([
                        'status' => true,
                        'message' => 'Sync successful..',
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
                            'device_id' => $device_id,
                            'device_token' => $dv_token,
                            'device_count' => $count,
                            'device_host' => $host,
                            'device_count_max' => config('devices.max_devices'),
                        ],
                    ], 200);
                } else {
                    Cache::put('sync', false);
                    return response()->json([
                        'status' => false,
                        'message' => 'Device limit exceeded',
                        'errors' => (object)[],
                        'data' => (object)[],
                    ], 404);
                }
            } elseif ($data['force_sync'] == true && $user == null) {
                $device = new device();
                $device->device_id = $device_id;
                $device->device_token = $dv_token;
                $device->device_name = $device_name;
                $device->client_id = $client_id;
                $device->host = $host;
                $device->save();
                $count = $user_count + 1;
                $client->device_id = $device_id;
                $client->host = $host;
                $client->save();

                Cache::put('sync', true);
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
                        'device_id' => $device_id,
                        'device_token' => $dv_token,
                        'device_host' => $host,
                        'device_count' => $count,
                        'device_count_max' => config('devices.max_devices'),
                    ],
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'sync failed',
                    'errors' => (object)[],
                    'data' => (object)[],
                ], 404);
            }
        } catch (Exception $e) {
            Log::error('Error sync: ' . $e->getMessage());
            Cache::put('sync', false);
            return response()->json([
                'error' => $e->getMessage(),
            ]);
        }
    }
}
