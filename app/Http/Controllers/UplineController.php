<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\earnings;
use App\Models\groups;
use App\Models\upline;
use App\Models\upline_earning;
use App\Models\User;
use App\Models\user_groups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class UplineController extends Controller
{
    public function index()
    {
        $data = groups::all();
        $users = User::where('name', '!=', 'admin')->get();
        $upline = Upline::join('groups as g1', 'uplines.upline_id', '=', 'g1.id')
            ->leftJoin('groups as g2', 'uplines.role', '=', 'g2.id')
            ->select('uplines.*', 'g1.group_name as upline_group_name', 'g2.group_name as role_group_name')
            ->get();
        return view('frontend.admin.pages.upline.index')->with(['data' => $data, 'user' => $users, 'upline' => $upline]);
    }

    public function create(Request $request)
    {
        upline::create([
            'upline_id' => $request->input('upline_role'),
            'role' => $request->input('role') == null ? null : $request->input('role'),
            'users' => $request->input('users') == null ? null : serialize($request->input('users')),
            'amount' => $request->input('amount')
        ]);
        return response()->json($request->all());
    }

    public function view_upline($id)
    {
        $is_role = true;
        $downline_role = [];
        $downline_users = [];
        $data = upline::where('id', $id)->first();
        $upline_name = groups::where('id', $data->upline_id)->first();
        if ($data->role != null) {
            $is_role = true;
            $group_name = groups::where('id', $data->role)->first();
            $downline_role[] = [
                'data' => $group_name->group_name,
                'group_id' => $id,
                'upline' => $upline_name->group_name,
                'amount' => $data->amount
            ];
        } else {
            $is_role = false;
            foreach (unserialize($data->users) as $user) {
                $user_name = User::where('id', $user)->first();
                $downline_users[] = [
                    'user' => $user_name->name,
                    'user_id' => $user_name->id,
                    'upline' => $upline_name->group_name,
                    'amount' => $data->amount,
                    'group_id' => $id
                ];
            }
        }
        return view('frontend.admin.pages.upline.view_upline')->with(['is_role' => $is_role, 'downline_role' => $downline_role, 'downline_users' => $downline_users]);
    }

    public function delete_user(Request $request)
    {
        $upline = upline::where('id', $request->input('group_id'))->first();
        $usersArray = unserialize($upline->users);
        $key = array_search($request->input('user_id'), $usersArray);
        if ($key !== false) {
            unset($usersArray[$key]);
        }
        $serializedData = serialize($usersArray);
        $upline->update(['users' => $serializedData]);
        $length = unserialize($serializedData);
        if (empty($length)) {
            $upline->delete();
        }
        Session::flash('success', 'Downline user deleted successfully');
        return redirect()->route('/admin/upline');
    }

    public function delete_role(Request $request)
    {
        $upline = upline::where('id', $request->input('group_id'))->first();
        $upline->delete();
        Session::flash('success', 'Downline user deleted successfully');
        return redirect()->route('/admin/upline');
    }

    // upline commission distribute
    public function upline_commission($user_id)
    {
        $arr = [];
        $uplines = upline::orderBy('created_at', 'desc')->get();
        try {
            foreach ($uplines as $upline) {
                $downline = $upline->role == null ? 'users' : 'role';
                // role based commission
                if ($downline == 'role') {
                    $user_groups = user_groups::where('g_id', $upline->role)->where('u_id', $user_id)->first();
                    if ($user_groups == null) {
                        continue;
                    } else {
                        if (in_array($upline->upline_id, $arr)) {
                            return;
                        }
                        upline_earning::create([
                            'upline_id' =>  $upline->upline_id,
                            'downline_id' =>  $user_id,
                            'amount' =>  $upline->amount
                        ]);
                        $arr[] = $upline->upline_id;
                    }
                }
                //user based commission
                else {
                    $users = unserialize($upline->users);
                    $key = array_search($user_id, $users);
                    dd($user_id);

                    if ($key == false) {
                        continue;
                    } else {
                        if (in_array($upline->upline_id, $arr)) {
                            return;
                        }
                        upline_earning::create([
                            'upline_id' =>  $upline->upline_id,
                            'downline_id' =>  $user_id,
                            'amount' =>  $upline->amount
                        ]);
                        $arr[] = $upline->upline_id;
                    }
                }
                return;
            }
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());

            return;
        }
    }
}
