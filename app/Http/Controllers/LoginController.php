<?php

namespace App\Http\Controllers;

use App\Models\clients;
use App\Models\otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\FrontendController;

class LoginController extends Controller
{
    public function index()
    {
        return view('frontend/auth/login');
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

    public function login_otp(Request $request)
    {
        $user_data = session('user_data');
        $user = otp::where('email', $user_data)
            ->orWhere('mobile', $user_data)
            ->orderBy('created_at', 'desc')
            ->first();
        $client = clients::where('mobile_number', $user_data)
            ->orWhere('email', $user_data)
            ->first();
        if ($user) {
            if ($user->otp == $request->input('otp')) {
                Session::forget('user_id');
                Session::forget('user_name');
                Session::forget('user_data');

                $request->session()->put('user_id', $client->client_id);
                $request->session()->put('user_name', $client->name);
                return redirect('/')->with('success', 'Login successful');
            }
        } else {
            return redirect()->back()->withErrors(['error' => 'Invalid credentials'])->withInput();
        }
    }



    public function generate_otp()
    {
        $session = session();
        if (session('user_data')) {

            $userInput = session('user_data');
            $tempOTP = rand(100000, 999999);

            $model = new otp();
            if (is_numeric($userInput)) {

                $data = [
                    'otp' => $tempOTP,
                    'isexpired' => 1,
                    'mobile' => $userInput,
                ];
                //Save OTP in DB
                $model->create($data);



                $message = $tempOTP . ' is the OTP to login at RTS. Valid for 1 min only. RTS LLP';
                //Send OTP
                $frontendcontroller = new FrontendController;
                $frontendcontroller->sendOTP($userInput, $message);
            } else { //send OTP to email id

                $data = [
                    'otp' => $tempOTP,
                    'isexpired' => 1,
                    'email' => $userInput,
                ];
                //Save OTP in DB
                $model->create($data);
                //Send Email Otp

                $frontendcontroller = new FrontendController;
                $frontendcontroller->sendEmailOtp($userInput, $tempOTP);
            }

            $data = array(
                'pageTitle' => 'PRIVATECH-LOGIN'
            );

            return view('frontend.auth.login_otp');
        } else {

            return redirect()->back();
        }
    }
}
