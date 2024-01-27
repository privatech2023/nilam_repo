<?php

namespace App\Http\Controllers;

use App\Models\clients;
use App\Models\issue_token;
use Illuminate\Http\Request;

class issueTokenController extends Controller
{
    public function index()
    {
        $data = issue_token::where('client_id', session('user_id'))->get();
        return view('frontend.pages.issue.index')->with(['data' => $data]);
    }

    public function create(Request $request)
    {
        $user = clients::where('client_id', session('user_id'))->first();

        if ($user->device_id == null) {
            session()->flash('error', 'Please sync your device to raise an issue');
            return redirect()->route('issue_token');
        }
        $issue = new issue_token();

        $issue->name = $request->input('name');
        $issue->detail = $request->input('detail');
        $issue->device_id = $user->device_id;
        $issue->device_token = $user->device_token;
        $issue->client_id = $user->client_id;
        $issue->start_date = date('Y-m-d');
        $issue->mobile_number = $request->input('mobile_number');
        $issue->save();
        session()->flash('success', 'Issue token raised successfully');
        return redirect()->route('issue_token');
    }
}
