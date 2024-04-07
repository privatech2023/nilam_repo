<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\earnings;
use App\Models\upline_earning;
use App\Models\User;
use App\Models\user_groups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EarningsController extends Controller
{
    public function index()
    {
        return view('frontend.admin.pages.earning.index');
    }

    public function index_2()
    {
        return view('frontend.admin.pages.earning.upline_earning');
    }

    public function ajaxAllEarnings(Request $request)
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $searchValue = $request->input('search.value');
        $valueStatus = $request->input('status');

        $query = earnings::where('user_id', session('admin_id'))
            ->join('clients', 'earnings.client_id', '=', 'clients.client_id')
            ->orderBy('earnings.created_at', 'desc')
            ->select('earnings.*', 'clients.name', DB::raw("DATE_FORMAT(earnings.created_at, '%Y-%m-%d') as formatted_created_at"));
        if (!empty($searchValue)) {
            $query->where('name', 'like', '%' . $searchValue . '%');
        } elseif (!empty($valueStatus)) {
            $query->where('is_active', $valueStatus);
        }

        $total_count = $query->count();
        $data = $query->skip($start)->take($length)->get();

        $json_data = [
            "draw" => intval($draw),
            "recordsTotal" => $total_count,
            "recordsFiltered" => $total_count,
            "data" => $data->toArray(),
        ];
        return response()->json($json_data);
    }


    public function ajaxAllUplineEarnings(Request $request)
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $searchValue = $request->input('search.value');
        $valueStatus = $request->input('status');

        $query = upline_earning::where('upline_id', session('admin_id'))
            ->join('users', 'upline_earnings.downline_id', '=', 'users.id')
            ->orderBy('upline_earnings.created_at', 'desc')
            ->select('upline_earnings.*', 'users.name', DB::raw("DATE_FORMAT(upline_earnings.created_at, '%Y-%m-%d') as formatted_created_at"));
        if (!empty($searchValue)) {
            $query->where('name', 'like', '%' . $searchValue . '%');
        } elseif (!empty($valueStatus)) {
            $query->where('is_active', $valueStatus);
        }

        $total_count = $query->count();
        $data = $query->skip($start)->take($length)->get();

        $json_data = [
            "draw" => intval($draw),
            "recordsTotal" => $total_count,
            "recordsFiltered" => $total_count,
            "data" => $data->toArray(),
        ];
        return response()->json($json_data);
    }

    public function get_direct_earnings($id)
    {
        $user = User::where('id', $id)->first();
        $data = DB::table('earnings')
            ->join('clients', 'earnings.client_id', '=', 'clients.client_id')
            ->select('clients.name', 'clients.mobile_number', 'earnings.commission', 'earnings.created_at')
            ->where('earnings.user_id', $id)
            ->get();

        if (!$data->isEmpty()) {
            return response()->json([
                'status' => 200,
                'data' => $data,
                'user' => $user
            ]);
        } else {
            return response()->json([
                'status' => 404
            ]);
        }
    }


    public function get_upline_earnings($id)
    {
        $group = user_groups::where('u_id', $id)->first();
        $username = User::where('id', $id)->first();
        $data = upline_earning::where('upline_id', $group->g_id)->get();

        $data = DB::table('upline_earnings')
            ->join('users', 'upline_earnings.downline_id', '=', 'users.id')
            ->select('users.name', 'upline_earnings.amount', 'upline_earnings.created_at')
            ->where('upline_earnings.upline_id', $group->g_id)
            ->get();
        if (!$data->isEmpty()) {
            return response()->json([
                'status' => 200,
                'data' => $data,
                'user_name' => $username->name
            ]);
        } else {
            return response()->json([
                'status' => 404
            ]);
        }
    }
}
