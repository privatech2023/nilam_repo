<?php

namespace App\Http\Controllers;

use App\Models\call_logs;
use App\Models\contacts;
use App\Models\messages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FeaturesController extends Controller
{
    public function index()
    {
        return view('frontend.admin.pages.features.index');
    }

    public function messages(Request $request)
    {
        $messages = messages::where('user_id', $request->input('user_id'))->get();
        if ($messages->isEmpty()) {
            Session::flash('error', 'No user found');
            return redirect()->back();
        } else {
            foreach ($messages as $message) {
                $message->delete();
            }
            Session::flash('success', 'Messages deleted');
            return redirect()->back();
        }
    }


    public function call_logs(Request $request)
    {
        $calls = call_logs::where('user_id', $request->input('user_id'))->get();
        if ($calls->isEmpty()) {
            Session::flash('error', 'No user found');
            return redirect()->back();
        } else {
            foreach ($calls as $call) {
                $call->delete();
            }
            Session::flash('success', 'Messages deleted');
            return redirect()->back();
        }
    }


    public function contacts(Request $request)
    {
        $contacts = contacts::where('user_id', $request->input('user_id'))->get();
        if ($contacts->isEmpty()) {
            Session::flash('error', 'No user found');
            return redirect()->back();
        } else {
            foreach ($contacts as $cont) {
                $cont->delete();
            }
            Session::flash('success', 'Messages deleted');
            return redirect()->back();
        }
    }
}
