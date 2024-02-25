<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\clients;
use App\Models\device;
use App\Models\my_devices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

class MyDeviceController extends Controller
{
    public function uploadDevice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'nullable|string|required_if:force_sync,true',
            'device_token' => 'nullable|string|required_if:force_sync,true',
            'json_file' => 'required|file|mimes:json|max:18000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
                'errors' => (object)$validator->errors()->toArray(),
                'data' => (object)[],
            ], 401);
        }

        $data = $request->only(['device_id', 'device_token', 'json_file']);
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
        $json_file = $data['json_file'];
        $json_file_path = 'mydevices/' . $device_id  . '/' . $json_file->getClientOriginalName();
        $json_file->storeAs('mydevices/' .  $device_id, $json_file->getClientOriginalName());
        $json_file_content = file_get_contents(storage_path('app/' . $json_file_path));
        $json_file_content = json_decode($json_file_content, true);
        try {
            $device_data = $json_file_content;
            $devicelist = device::where('host', $device_data['host'])->where('client_id', $user->client_id)->first();
            if ($devicelist == null) {
                return response()->json([
                    'status' => false,
                    'message' => 'No device found',
                    'errors' => (object)[],
                    'data' => (object)[],
                ], 404);
            } else {
                $devicelist->update([
                    'manufacturer' => $device_data['manufacturer'],
                    'android_version' => $device_data['android-version'],
                    'product' => $device_data['product'],
                    'model' => $device_data['model'],
                    'brand' => $device_data['brand'],
                    'device' => $device_data['device'],
                    'battery' => $device_data['battery'],
                    'updated_at' => now(),
                ]);
                return response()->json([
                    'status' => true,
                    'message' => 'Device uploaded ',
                    'errors' => (object)[],
                    'data' => (object)[],
                ], 200);
            }

            unlink(storage_path('app/' . $json_file_path));
        } catch (\Exception $e) {
            unlink(storage_path('app/' . $json_file_path));
            $errors = (object)[];
            if (config('app.debug')) {
                $errors = (object)[
                    'exception' => [$e->getMessage()],
                    'trace' => $e->getTrace(),
                ];
            }
            return response()->json([
                'status' => false,
                'message' => 'Failed to upload device',
                'errors' => $errors,
                'data' => (object)[],
            ], 500);
        }
    }
}
