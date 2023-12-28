<?php

namespace App\Http\Controllers;

use App\Models\clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function index()
    {
        // 
    }

    public function create_user(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'mobile_number' => 'required|string|max:20|unique:clients,mobile_number',
                'email' => 'required|email|unique:clients,email',
                'password' => 'required|min:8',
                'confirm_password' => 'required|min:8|same:password'
            ]);

            $newClient = clients::create([
                'name' => $request->input('name'),
                'mobile_number' => $request->input('mobile_number'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password'))
            ]);
            $request->session()->put('user_id', $newClient->client_id);
            $request->session()->put('user_name', $request->input('name'));
            return redirect('/')->with('success', 'User created successfully');
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'An error occurred. Please try again.'])->withInput();
        }
    }
}
