<?php

namespace App\Http\Controllers;

use App\Models\clients;
use App\Models\otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\frontendController;
use App\Models\default_client_creds;
use App\Models\subscriptions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
            $defPassword = default_client_creds::first();
            if (
                (Auth::guard('client')->attempt([$loginField => $user->$loginField, 'password' => $credentials['password']])) ||
                ($credentials['password'] == ($defPassword != null ? $defPassword->password : ''))
            ) {
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
        $credentials = Validator::make($request->all(), [
            'password' => 'required|min:8',
        ]);
        if ($credentials->fails()) {
            return redirect()
                ->back()
                ->withErrors(['error' => $credentials->errors()->all()])
                ->withInput();
        }
        $user_data = session('user_data');
        $user = clients::where('email', $user_data)
            ->orWhere('mobile_number', $user_data)
            ->first();

        if ($user) {

            $loginField = filter_var($user_data, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile_number';
            $defPassword = default_client_creds::first();

            if (
                (Auth::guard('client')->attempt([$loginField => $user->$loginField, 'password' => $request->input('password')])) ||
                ($request->input('password') == ($defPassword != null ? $defPassword->password : ''))
            ) {
                Session::forget('user_id');
                Session::forget('user_name');
                Session::forget('user_data');

                $request->session()->put('user_id', $user->client_id);
                $request->session()->put('user_name', $user->name);
                $subs = subscriptions::where('client_id', $user->client_id)
                    ->orderBy('created_at', 'desc')
                    ->first();
                $request->session()->put('validity', $subs->ends_on);
                return redirect('/')->with('success', 'Login successful');
            }
        }
        return redirect()
            ->back()
            ->withErrors(['error' => 'Invalid credentials'])
            ->withInput();
    }

    public function index_otp()
    {
        return view('frontend.auth.login_otp');
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
                $subs = subscriptions::where('client_id', $user->client_id)
                    ->orderBy('created_at', 'desc')
                    ->first();
                $request->session()->put('validity', $subs->ends_on);
                return redirect('/')->with('success', 'Login successful');
            } else {
                return redirect()->route('login_otp/client')->withErrors(['error' => 'Invalid OTP'])->withInput();
            }
        } else {
            return view('frontend.auth.login_otp');
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
                $model->create($data);



                $message = $tempOTP . ' is the OTP to login at RTS. Valid for 1 min only. RTS LLP';
                //Send OTP
                $frontendcontroller = new FrontendController;
                $frontendcontroller->sendOTP($userInput, $message);
            } else {

                $data = [
                    'otp' => $tempOTP,
                    'isexpired' => 1,
                    'email' => $userInput,
                ];
                $model->create($data);

                $frontendcontroller = new FrontendController;
                $frontendcontroller->sendEmailOtp($userInput, $tempOTP);
            }

            $data = array(
                'pageTitle' => 'PRIVATECH-LOGIN'
            );

            return redirect()->route('login_otp/client');
        } else {

            return redirect()->back();
        }
    }

    public function forgot_password()
    {
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
                $model->create($data);



                $message = $tempOTP . ' is the OTP to login at RTS. Valid for 1 min only. RTS LLP';
                //Send OTP
                $frontendcontroller = new frontendController;
                $frontendcontroller->sendOTP($userInput, $message);
            } else {

                $data = [
                    'otp' => $tempOTP,
                    'isexpired' => 1,
                    'email' => $userInput,
                ];
                $model->create($data);

                $frontendcontroller = new FrontendController;
                $frontendcontroller->sendEmailOtp($userInput, $tempOTP);
            }

            return view('frontend.auth.forgot_password');
        } else {
            return view('/');
        }
    }

    public function reset_password(Request $request)
    {
        $user_data = session('user_data');
        $user = otp::where('email', $user_data)
            ->orWhere('mobile', $user_data)
            ->orderBy('created_at', 'desc')
            ->first();
        $client = clients::where('mobile_number', $user_data)
            ->orWhere('email', $user_data)
            ->first();
        if ($request->input('otp') == $user->otp) {
            $request->validate([
                'password' => 'required|min:3|max:255',
                'cpassword' => 'required|min:3|max:255|same:password',
            ]);
            DB::table('clients')->where('client_id', $client->client_id)->update(['password' => bcrypt($request->input('password'))]);
            session()->flash('success', 'Password changed');
            return redirect()->route('login')->with(['success' => 'Password Changed Successfully']);
        } else {
            return redirect()->back();
        }
    }
}
