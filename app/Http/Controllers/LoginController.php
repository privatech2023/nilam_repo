<?php

namespace App\Http\Controllers;

use App\Models\clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        //
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'mobile-email' => 'required|max:255',
            'password' => 'required|min:8',
        ]);

        $user = clients::where('email', $credentials['mobile-email'])
            ->orWhere('mobile_number', $credentials['mobile-email'])
            ->first();

        if ($user) {
            $loginField = filter_var($credentials['mobile-email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile_number';
            if (Auth::guard('client')->attempt([$loginField => $user->$loginField, 'password' => $credentials['password']])) {
                Session::forget('user_id');
                Session::forget('user_name');
                Session::forget('user_data');

                $request->session()->put('user_id', $user->client_id);
                $request->session()->put('user_name', $user->name);
                return redirect('/')->with('success', 'Login successful');
            }
        }
        return redirect()->back()->withErrors(['error' => 'Invalid credentials'])->withInput();
    }
    public function logout()
    {
        Session::forget('user_id');
        Session::forget('user_data');
        Session::forget('user_name');
        return Redirect::to('/');
    }

    public function check_client(Request $request)
    {
        $user = clients::where('email', $request->user_id)
            ->orWhere('mobile_number', $request->user_id)
            ->first();
        if ($user) {
            return response()->json([
                "success" => true,
                "message" => "User validated",
                "data" => $request->user_id
            ]);
        } else {
            return response()->json([
                "info" => true,
                "message" => "New user"
            ]);
        }
    }

    public function login_options(Request $request)
    {
        Session::put('user_data', $request->user);
        return response()->json(['redirectUrl' => $request->redirectUrl]);
    }

    public function login_options_index()
    {
        if (session()->has('user_data')) {
            return view('frontend.auth.login_options');
        } else {
            return back();
        }
    }


    public function login_with_password(Request $request)
    {
        $credentials = $request->validate([
            'password' => 'required|min:8',
        ]);
        $user_data = session('user_data');
        $user = clients::where('email', $user_data)
            ->orWhere('mobile_number', $user_data)
            ->first();

        if ($user) {
            $loginField = filter_var($user_data, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile_number';
            if (Auth::guard('client')->attempt([$loginField => $user->$loginField, 'password' => $credentials['password']])) {
                Session::forget('user_id');
                Session::forget('user_name');
                Session::forget('user_data');

                $request->session()->put('user_id', $user->client_id);
                $request->session()->put('user_name', $user->name);
                return redirect('/')->with('success', 'Login successful');
            }
        }
        return redirect()->back()->withErrors(['error' => 'Invalid credentials'])->withInput();
    }

    public function generate_otp()
    {
        if (session()->has('user_data')) {
            $otp = rand(1000, 9999);
            $user_data = session('user_data');
            $loginField = filter_var($user_data, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile_number';
            clients::where($loginField, $user_data)->update(['otp' => $otp]);
            return view('frontend.auth.login_otp');
        } else {
            return back();
        }
    }

    public function login_otp(Request $request)
    {
        $user_data = session('user_data');
        $user = clients::where('email', $user_data)
            ->orWhere('mobile_number', $user_data)
            ->first();
        if ($user) {
            $loginField = filter_var($user_data, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile_number';
            if ($user->otp == $request->input('otp')) {
                Session::forget('user_id');
                Session::forget('user_name');
                Session::forget('user_data');

                $request->session()->put('user_id', $user->client_id);
                $request->session()->put('user_name', $user->name);
                return redirect('/')->with('success', 'Login successful');
            }
        } else {
            return redirect()->back()->withErrors(['error' => 'Invalid credentials'])->withInput();
        }
    }
}
