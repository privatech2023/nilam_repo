<?php

namespace App\Http\Controllers;

use App\Models\groups;
use App\Models\User;
use App\Models\user_clients;
use App\Models\user_groups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class usersController extends Controller
{
    public function index()
    {
        $data = User::where('name', '!=', 'admin')->get();
        return view('frontend.admin.pages.users.index')->with(['data' => $data]);
    }

    public function update_index($id)
    {
        $groups = groups::all();
        $data = User::where('id', '=', $id)->get();
        return view('frontend.admin.pages.users.update')->with(['data' => $data, 'groups' => $groups]);
    }

    public function add_user_index()
    {
        $data = groups::where('id', '!=', 1)->get();
        return view('frontend.admin.pages.users.add')->with(['data' => $data]);
    }

    public function create_user(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|numeric|min:10|unique:users,mobile',
            'password' => 'required|min:3|max:255',
            'passconf' => 'required|min:3|max:255|same:password',
            'status' => 'required',
            'role' => 'required',
            'gender' => 'required'
        ]);
        $logged_user = session()->get('admin_id');
        $g_id = $request->input('role');
        $adminController = new adminController;
        $user_type = $adminController->roleNameByID($g_id);

        $newClient = User::create([
            'name' => $request->input('name'),
            'mobile' => $request->input('mobile'),
            'email' => $request->input('email'),
            'gender' => $request->input('gender'),
            'status' => $request->input('status'),
            'user_type' => $user_type,
            'created_by' => $logged_user,
            'password' => bcrypt($request->input('password'))
        ]);

        if ($logged_user) {
            $last_user_id = $newClient->id;
            if ($last_user_id) {
                $groupData = [
                    'u_id' => $last_user_id,
                    'g_id' => $g_id,
                ];
                user_groups::create($groupData);
            }
            session()->flash('success', 'User created successfully');
            $data = User::where('name', '!=', 'admin')->get();
            return view('frontend.admin.pages.users.index')->with(['data' => $data, 'success' => 'User created successfully']);
        }
    }

    public function update_user(Request $request)
    {
        try {
            $user = User::find($request->input('user_id'));

            if (!$user) {
                return redirect()->back()->withErrors(['error' => 'User not found']);
            }

            $logged_user = session()->get('admin_id');
            $g_id = $request->input('role');
            $adminController = new adminController;
            $user_type = $adminController->roleNameByID($g_id);

            $user->name = $request->input('name');
            $user->mobile = $request->input('mobile');
            $user->email = $request->input('email');
            $user->gender = $request->input('gender');
            $user->status = $request->input('status');
            $user->user_type = $user_type;
            $user->created_by = $logged_user;
            if ($request->input('password') != '') {
                if ($request->input('password') != $request->input('passconf')) {
                    session()->flash('error', 'Confirm password mismatch');
                    $data = User::where('name', '!=', 'admin')->get();
                    return view('frontend.admin.pages.users.index')->with(['data' => $data, 'success' => 'User updated successfully']);
                } else {
                    $user->password = bcrypt($request->input('password'));
                }
            }
            // $user->password = bcrypt($request->input('password'));
            $user->save();
            if ($request->input('status') == 2) {
                user_clients::where('user_id', $request->input('user_id'))->delete();
                $d = new CommissionController;
                $d->distribute_clients_old();
            }
            if ($logged_user) {
                $last_user_id = $user->id;
                if ($last_user_id) {
                    $groupData = [
                        'u_id' => $last_user_id,
                        'g_id' => $g_id,
                    ];
                    user_groups::updateOrCreate(
                        ['u_id' => $last_user_id],
                        $groupData
                    );
                }
            }
            session()->flash('success', 'User updated successfully');
            $data = User::where('name', '!=', 'admin')->get();
            return view('frontend.admin.pages.users.index')->with(['data' => $data, 'success' => 'User updated successfully']);
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'An error occurred. Please try again.'])->withInput();
        }
    }

    public function delete_user(Request $request)
    {
        $user = User::find($request->input('row_id'));
        $user->delete();
        session()->flash('success', 'Role Deleted');
        $data = User::where('name', '!=', 'admin')->get();
        return view('frontend.admin.pages.users.index')->with(['data' => $data, 'success' => 'User deleted successfully']);
    }
}
