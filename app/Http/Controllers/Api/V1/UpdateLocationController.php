<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\clients;
use App\Models\device;
use App\Models\location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UpdateLocationController extends Controller
{
    public function updateLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'nullable',
            'lat' => 'required',
            'lng' => 'required',
            'device_token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Device location update failed',
                'errors' => (object)$validator->errors()->toArray(),
                'data' => (object)[],
            ], 422);
        }

        $data = $request->only(['device_id', 'lat', 'lng', 'device_token']);

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

        $location = location::where('device_id', $data['device_id'])->where('client_id', $user->client_id)->first();
        if ($location == null) {
            $location_new = new location();
            $location_new->create([
                'device_id' => $data['device_id'],
                'client_id' =>  $user->client_id,
                'lat' => $data['lat'],
                'long' => $data['lng']
            ]);
        } else {
            $location->update([
                'lat' => $data['lat'],
                'long' => $data['lng'],
            ]);
        }


        return response()->json([
            'status' => true,
            'message' => 'Device location updated',
            'errors' => (object)[],
            'data' => (object)[],
        ], 200);
    }
}
