<?php

namespace App\Http\Controllers;

use App\Models\activation_codes;
use App\Models\coupons;
use App\Models\groups;
use App\Models\packages;
use App\Models\roles;
use App\Models\transactions;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class adminController extends Controller
{
    public function index()
    {
        $transactions = transactions::all();
        $packages = packages::all();
        $activation_codes = activation_codes::all();
        $coupons = coupons::all();
        return view('frontend.admin.dashboard')->with(['transactions' => count($transactions), 'packages' => count($packages), 'activation_codes' => count($activation_codes), 'coupons' => count($coupons)]);
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
        $data = groups::all();
        return view('frontend.admin.pages.roles.index')->with(['data' => $data]);
    }

    public function create_roles()
    {
        $data = groups::all();
        return view('frontend.admin.pages.roles.create-roles')->with(['data' => $data]);
    }


    public function roleNameByID($role)
    {
        $group = groups::select('group_name')->where('id', $role)->first();

        return $group ? $group->group_name : null;
    }

    public function profile_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'mobile_number' => 'required|numeric',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|string|same:password',
        ]);

        if ($validator->fails()) {
            $data = User::where('id', $request->input('id'))
                ->first();
            Session::flash('error', $validator->errors());
            return view('frontend.admin.pages.profile.index')->with(['data' => $data]);
        }
        // Find the user by ID
        $user = User::find($request->input('id'));

        if (!$user) {
            $data = User::where('id', $request->input('id'))
                ->first();
            return view('frontend.admin.pages.profile.index')->with(['data' => $data]);
        }

        // Update the user
        $user->name = $request->input('name');
        $user->mobile = $request->input('mobile_number');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        $data = User::where('id', $request->input('id'))
            ->first();
        Session::flash('success', 'Updated credentials');
        return view('frontend.admin.pages.profile.index')->with(['data' => $data]);
    }

    public function profile($id)
    {
        $data = User::where('id', $id)
            ->first();
        return view('frontend.admin.pages.profile.index')->with(['data' => $data]);
    }
}
