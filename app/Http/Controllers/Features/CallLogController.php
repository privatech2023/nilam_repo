<?php

namespace App\Http\Controllers\Features;

use App\Http\Controllers\Controller;
use App\Models\call_logs;
use App\Models\clients;
use Illuminate\Http\Request;

class CallLogController extends Controller
{
    public function get_call_logs($id)
    {
        $user = clients::where('client_id', session('user_id'))->first();
        $calls = call_logs::where('user_id', $user->client_id)
            ->where('device_id', $user->device_id)
            ->orderByRaw("DATE_FORMAT(date, '%Y-%m-%d %H:%i:%s') DESC")
            ->take(60)
            ->get();
        return response()->json(['calls' => $calls]);
    }
}
