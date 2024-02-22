<?php

namespace App\Http\Controllers;

use App\Models\clients;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class subscriptionController extends Controller
{
    public function index()
    {
        return view('frontend.admin.pages.subscription.index');
    }
    public function active()
    {
        return view('frontend.admin.pages.subscription.active');
    }
    public function pending()
    {
        return view('frontend.admin.pages.subscription.pending');
    }
    public function expired()
    {
        return view('frontend.admin.pages.subscription.expired');
    }

    public function ajaxCallAllClients()
    {
        $today = now('Asia/Kolkata');

        $params['draw'] = request('draw');
        $start = request('start');
        $length = request('length');
        $total_count = [];
        $data = [];

        $valueStatus = request('status', '');
        $search_value = request('search.value', '');
        $valueRegistration = request('registration', '');

        if (!empty($search_value)) {
            $query =  DB::table('clients')
                ->select('clients.client_id', 'clients.name', 'subscriptions.updated_at', 'clients.mobile_number', 'clients.email', 'clients.status', 'subscriptions.status as subscriptions', 'subscriptions.started_at', 'subscriptions.ends_on')
                ->Join('subscriptions', function ($join) use ($today) {
                    $join->on('clients.client_id', '=', 'subscriptions.client_id');
                })
                ->where('name', 'like', '%' . $search_value . '%')
                ->orderBy('subscriptions.updated_at', 'desc')
                ->get();

            $total_count = $query->toArray();

            $data = DB::table('clients')
                ->select('clients.client_id', 'clients.name', 'subscriptions.updated_at', 'clients.mobile_number', 'clients.email', 'clients.status', 'subscriptions.status as subscriptions', 'subscriptions.started_at', 'subscriptions.ends_on')
                ->Join('subscriptions', function ($join) use ($today) {
                    $join->on('clients.client_id', '=', 'subscriptions.client_id');
                })
                ->where('name', 'like', '%' . $search_value . '%')
                ->orderBy('subscriptions.updated_at', 'desc')
                ->skip($start)
                ->take($length)
                ->get()
                ->toArray();
        } elseif (!empty($valueStatus)) {
            $data = DB::table('clients')
                ->select('clients.client_id', 'clients.name', 'subscriptions.updated_at', 'clients.mobile_number', 'clients.email', 'clients.status', 'subscriptions.status as subscriptions', 'subscriptions.started_at', 'subscriptions.ends_on')
                ->Join('subscriptions', function ($join) use ($today) {
                    $join->on('clients.client_id', '=', 'subscriptions.client_id');
                })
                ->where('clients.status', $valueStatus)
                ->orderBy('subscriptions.updated_at', 'desc')
                ->get();
        } elseif (!empty($valueRegistration)) {
            $valueRegistration = date('Y-m-d', strtotime($valueRegistration));
            $data = DB::table('clients')
                ->select('clients.client_id', 'clients.name', 'subscriptions.updated_at', 'clients.mobile_number', 'clients.email', 'clients.status', 'subscriptions.status as subscriptions', 'subscriptions.started_at', 'subscriptions.ends_on')
                ->Join('subscriptions', function ($join) use ($today) {
                    $join->on('clients.client_id', '=', 'subscriptions.client_id');
                })
                ->whereRaw("DATE(subscriptions.updated_at) = ?", [$valueRegistration])
                ->orderBy('subscriptions.updated_at', 'desc')
                ->get();
        } else {
            $data = DB::table('clients')
                ->select('clients.client_id', 'clients.name', 'subscriptions.updated_at', 'clients.mobile_number', 'clients.email', 'clients.status', 'subscriptions.status as subscriptions', 'subscriptions.started_at', 'subscriptions.ends_on')
                ->Join('subscriptions', function ($join) use ($today) {
                    $join->on('clients.client_id', '=', 'subscriptions.client_id');
                })
                ->orderBy('subscriptions.updated_at', 'desc')
                ->get();
        }

        $json_data = [
            "draw" => intval($params['draw']),
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data),
            "data" => $data
        ];

        return response()->json($json_data);
    }


    public function ajaxCallAllClientsActive()
    {
        $today = date('Y-m-d');

        $draw = request('draw');
        $start = request('start');
        $length = request('length');
        $searchValue = request('search.value');
        $valueStatus = request('status', '');
        $valueRegistration = request('registration', '');

        $query = DB::table('clients')
            ->select('clients.client_id', 'subscriptions.updated_at', 'clients.name', 'clients.mobile_number', 'clients.email', 'clients.status', 'subscriptions.status as subscription', 'subscriptions.started_at', 'subscriptions.ends_on')
            ->leftJoin('subscriptions', function ($join) use ($today) {
                $join->on('clients.client_id', '=', 'subscriptions.client_id');
            })
            ->where('subscriptions.status', 1)
            ->where('subscriptions.ends_on', '>=', $today)
            ->groupBy('clients.client_id', 'clients.name', 'clients.mobile_number', 'clients.email', 'clients.status', 'subscriptions.status', 'subscriptions.started_at', 'subscriptions.ends_on', 'subscriptions.updated_at')
            ->orderByDesc('subscriptions.updated_at');

        if (!empty($searchValue)) {
            $query->where('clients.name', 'like', '%' . $searchValue . '%');
        }

        if (!empty($valueStatus)) {
            $query->where('clients.status', $valueStatus);
        }

        if (!empty($valueRegistration)) {
            $valueRegistration = date('Y-m-d', strtotime($valueRegistration));
            $query->whereRaw("DATE(subscriptions.updated_at) = ?", [$valueRegistration]);
        }

        $total_count = $query->get();

        $data = $query->skip($start)->take($length)->get();

        $json_data = [
            "draw" => intval($draw),
            "recordsTotal" => count($total_count),
            "recordsFiltered" => count($total_count),
            "data" => $data,
        ];

        return response()->json($json_data);
    }


    public function ajaxCallAllClientsPending()
    {
        $today = now('Asia/Kolkata');
        $params['draw'] = request('draw');
        $start = request('start');
        $length = request('length');
        $valueStatus = request('search.value');
        $search_value = request('status', '');
        $valueRegistration = request('registration', '');

        $query = DB::table('clients')
            ->select('clients.client_id', 'clients.name', 'clients.mobile_number', 'clients.email', 'clients.status', 'subscriptions.updated_at')
            ->leftJoin('subscriptions', function ($join) use ($today) {
                $join->on('clients.client_id', '=', 'subscriptions.client_id')
                    ->where('subscriptions.validity_days', null);
            })
            ->havingRaw('COUNT(subscriptions.client_id) > 0')
            ->groupBy('clients.client_id', 'clients.name', 'clients.mobile_number', 'clients.email', 'clients.status', 'subscriptions.status', 'subscriptions.updated_at')
            ->orderByDesc('subscriptions.updated_at');
        if (!empty($search_value)) {
            $query->where('clients.name', 'like', '%' . $search_value . '%');
        }
        if (!empty($valueStatus)) {
            $query->where('clients.status', $valueStatus);
        }

        if (!empty($valueRegistration)) {
            $valueRegistration = date('Y-m-d', strtotime($valueRegistration));
            $query->whereRaw("DATE(subscriptions.updated_at) = ?", [$valueRegistration]);
        }

        $total_count = $query->get();
        $data = $query->skip($start)->take($length)->get();

        $json_data = [
            "draw" => intval($params['draw']),
            "recordsTotal" => $total_count->count(),
            "recordsFiltered" => $total_count->count(),
            "data" => $data->toArray()
        ];

        return response()->json($json_data);
    }


    public function ajaxCallAllClientsExpired(Request $request)
    {
        $today = Carbon::today('Asia/Kolkata')->toDateString();

        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $search_value = $request->input('search.value');
        $valueStatus = $request->input('status');
        $valueRegistration = request('registration', '');

        $query = clients::select('clients.client_id', 'clients.name', 'clients.mobile_number', 'clients.email', 'clients.status', 'subscriptions.updated_at', 'subscriptions.started_at', 'subscriptions.ends_on', DB::raw('0 as subscription'))
            ->leftJoin('subscriptions', 'clients.client_id', '=', 'subscriptions.client_id')
            ->where('subscriptions.status', 1)
            ->where('subscriptions.ends_on', '<', $today)
            ->orderByDesc('subscriptions.updated_at');


        if (!empty($search_value)) {
            $query->where('clients.name', 'like', '%' . $search_value . '%');
        }

        if (!empty($valueStatus)) {
            $query->where('clients.status', $valueStatus);
        }

        if (!empty($valueRegistration)) {
            $valueRegistration = date('Y-m-d', strtotime($valueRegistration));
            $query->whereRaw("DATE(subscriptions.updated_at) = ?", [$valueRegistration]);
        }

        $total_count = $query->get()->count();

        $data = $query->skip($start)->take($length)->get();

        $json_data = array(
            "draw" => intval($draw),
            "recordsTotal" => $total_count,
            "recordsFiltered" => $total_count,
            "data" => $data
        );

        return response()->json($json_data);
    }
}
