<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CalllLogSyncController extends Controller
{
    public function uploadCallLogs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'json_file' => 'required|file|mimes:json,txt|max:10000',
            'device_token' => 'required',
            'device_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'callLog' => 'Failed to upload call logs',
                'errors' => (object)$validator->errors()->toArray(),
                'data' => (object)[],
            ], 422);
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
        $user = clients::where('device_token', $data['device_token'])->where('device_id', $data['device_id'])->first();
        if ($user == null) {
            return response()->json([
                'status' => false,
                'message' => 'No device found',
                'errors' => (object)[],
                'data' => (object)[],
            ], 406);
        }

        $json_file = $request->file('json_file');

        // Store the file in storage/app/callLogs/
        $json_file_path = 'callLogs/' . $json_file->getClientOriginalName();
        $json_file->storeAs('callLogs/', $json_file->getClientOriginalName());

        // Read the file contents
        $json_file_content = file_get_contents(storage_path('app/' . $json_file_path));
        $json_file_content = json_decode($json_file_content, true);



        try {
            $callLogs = $json_file_content['data'];

            $callLogsToInsert = [];
            $now = now();

            $user_id = $user->client_id;

            foreach ($callLogs as $callLog) {
                $callLog['user_id'] = $user->client_id;
                $callLog['device_id'] = $data['device_id'];
                $callLog['name'] = $callLog['name'];
                $callLog['number'] = $callLog['number'];
                $callLog['duration'] = $callLog['duration'];
                $callLog['date'] = $callLog['date'];
                $callLog['created_at'] = $now;
                $callLog['updated_at'] = $now;
                $callLogsToInsert[] = $callLog;
            }
            foreach (array_chunk($callLogsToInsert, 1000) as $chunk) {
                DB::table('call_logs')->insert($chunk);
            }

            // Delete old records if more than 500
            $count = DB::table('call_logs')->where('user_id', $user_id)->count();
            if ($count > 500) {
                $countToDelete = $count - 500;
                DB::table('call_logs')->where('user_id', $user_id)->orderBy('id', 'asc')->limit($countToDelete)->delete();
            }

            // Delete the file
            unlink(storage_path('app/' . $json_file_path));
        } catch (\Exception $e) {

            $errors = (object)[];
            if (config('app.debug')) {
                $errors = (object)[
                    'exception' => [$e->getMessage()],
                    'trace' => $e->getTrace(),
                ];
            }

            return response()->json([
                'status' => false,
                'callLog' => 'Failed to upload call logs',
                'errors' => $errors,
                'data' => (object)[],
            ], 500);
        }

        return response()->json([
            'status' => true,
            'callLog' => 'call logs uploaded',
            'errors' => (object)[],
            'data' => (object)[],
        ], 200);
    }
}
