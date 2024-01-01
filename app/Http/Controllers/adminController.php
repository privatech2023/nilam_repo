<?php

namespace App\Http\Controllers;

use App\Models\roles;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class adminController extends Controller
{
    public function index()
    {
        return view('frontend.admin.dashboard');
    }

    public function login_index()
    {
        return view('frontend.admin.auth.login');
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = User::where('email', $credentials['email'])->first();

            if ($user && password_verify($credentials['password'], $user->password)) {
                $request->session()->put('admin_id', $user->id);
                $request->session()->put('admin_name', $user->name);
                return redirect('/admin')->with('success', 'Login successful');
            } else {
                Log::info('Login failed for email: ' . $credentials['email']);
                return redirect()->back()->withErrors(['error' => 'Invalid credentials'])->withInput();
            }
        } catch (\Exception $e) {
            Log::error('Error during login: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'An error occurred. Please try again.'])->withInput();
        }
    }
    public function logout()
    {
        Session::flush();
        return Redirect::to('/');
    }

    public function roles()
    {
        $data = roles::all();
        return view('frontend.admin.pages.roles.index')->with(['data' => $data]);
    }

    public function create_roles()
    {
        $data = roles::all();
        return view('frontend.admin.pages.roles.create-roles')->with(['data' => $data]);
    }
}
