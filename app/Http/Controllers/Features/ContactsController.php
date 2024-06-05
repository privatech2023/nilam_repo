<?php

namespace App\Http\Controllers\Features;

use App\Http\Controllers\Controller;
use App\Models\clients;
use App\Models\contacts;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function get_contacts($id)
    {
        $user = clients::where('client_id', $id)->first();
        $contacts = contacts::where('device_id', $user->device_id)->where('user_id', $user->client_id)->orderBy('name')->where('number', '!=', null)
            ->get();
        return response()->json(['contacts' => $contacts]);
    }
}
