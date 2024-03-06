<?php

namespace App\Http\Controllers;

use App\Models\call_logs;
use App\Models\clients;
use App\Models\contacts;
use App\Models\gallery_items;
use App\Models\messages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

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
            Session::flash('success', 'messages deleted');
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
            Session::flash('success', 'call logs deleted');
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
            Session::flash('success', 'contacts deleted');
            return redirect()->back();
        }
    }


    public function gallery(Request $request)
    {
        $client = clients::where('client_id', $request->input('user_id'))->first();
        $model = gallery_items::where('device_id', $client->device_id)
            ->where('user_id', $request->input('user_id'))
            ->get();

        if ($model->isEmpty()) {
            Session::flash('error', 'No user found');
            return redirect()->back();
        } else {
            foreach ($model as $m) {
                $exists = Storage::disk('s3')->exists('gallery/images/' . $request->input('user_id') . '/' . $client->device_id . '/' . $m->media_url);
                if ($exists) {
                    Storage::disk('s3')->delete('gallery/images/' . $request->input('user_id') . '/' . $client->device_id . '/' . $m->media_url);
                }
                $m->delete();
            }
            Session::flash('success', 'gallery deleted');
            return redirect()->back();
        }
    }
}
