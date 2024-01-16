<?php

namespace App\Http\Controllers;

use App\Models\clients;
use App\Models\subscriptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function index()
    {
        return view('frontend/auth/register');
    }

    public function create_user(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'mobile_number' => 'required|string|max:20|unique:clients,mobile_number',
                'email' => ['required', 'email', 'unique:clients,email', 'regex:/^.+@.+\..+$/i'],
                'password' => 'required|min:8',
                'confirm_password' => 'required|min:8|same:password'
            ]);

            $newClient = clients::create([
                'name' => $request->input('name'),
                'mobile_number' => $request->input('mobile_number'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password'))
            ]);
            $client_id = $newClient->client_id;
            $subsmodel = new subscriptions();
            $subsData = [
                'client_id' => $client_id,
                'txn_id' => null,
                'started_at' => null,
                'ends_on' => null,
                'validity_days' => null,
                'status' => 2, //1 Active | 2 Pending                       
            ];
            $subsmodel->create($subsData);
            session()->flash('success', 'Registered succesfully');
            return redirect()->route('login')->with(['success' => 'Registered successfully']);
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'An error occurred. Please try again.'])->withInput();
        }
    }
}
