<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\clients;
use App\Models\device;
use App\Models\sim_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SimDetailsController extends Controller
{
    public function uploadSimDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'nullable|string|required_if:force_sync,true',
            'device_token' => 'nullable|string|required_if:force_sync,true',
            'json_file' => 'required|file|mimes:json|max:18000',
        ]);
        Log::error('In call sim details api');
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
            // $devicelist = sim_details::where('phone_number', $device_data['phone_number'])->where('device_id', $data['device_id'])->where('client_id', $user->client_id)->first();
            $devicelist = sim_details::where('device_id', $data['device_id'])->where('user_id', $user->client_id)->first();
            if ($devicelist == null) {
                $sim = new sim_details();
                $sim->user_id = $user->client_id;
                $sim->device_id = $data['device_id'];
                $sim->operator = $device_data['operator'];
                $sim->area = $device_data['area'];
                $sim->phone_number = 0;
                $sim->phone_number = null;
                $sim->save();
                return response()->json([
                    'status' => false,
                    'message' => 'Sim details saved',
                    'errors' => (object)[],
                    'data' => (object)[],
                ], 200);
            } else {
                $devicelist->user_id = $user->client_id;
                $devicelist->device_id = $data['device_id'];
                $devicelist->operator = $device_data['operator'];
                $devicelist->area = $device_data['area'];
                $devicelist->phone_number = 0;
                $devicelist->update();
                return response()->json([
                    'status' => true,
                    'message' => 'Sim details uploaded ',
                    'errors' => (object)[],
                    'data' => (object)[],
                ], 200);
            }
            unlink(storage_path('app/' . $json_file_path));
        } catch (\Exception $e) {
            Log::error('In call sim details api' . $e->getMessage());
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
                'message' => 'Failed to upload sim details',
                'errors' => $errors,
                'data' => (object)[],
            ], 500);
        }
    }
}
