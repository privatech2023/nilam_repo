<?php

namespace App\Http\Controllers;

use App\Models\clients;
use App\Models\device;
use App\Models\issue_token;
use App\Models\issue_type;
use App\Models\tech_tokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class issueTokenController extends Controller
{
    public function tech_index()
    {
        return view('frontend.admin.pages.tech.index');
    }


    public function index()
    {
        $issue_type = [];
        $data = issue_token::where('client_id', session('user_id'))->get();
        $type = issue_type::all();
        return view('frontend.pages.issue.index')->with(['data' => $data, 'type' => $type]);
    }

    public function create(Request $request)
    {
        $user = clients::where('client_id', session('user_id'))->first();
        if ($user->device_id == null) {
            session()->flash('error', 'Please sync your device to raise an issue');
            return redirect()->route('issue_token');
        }
        $issue = new issue_token();
        $issue->issue_type = $request->input('type');
        $issue->detail = $request->input('detail');
        $issue->device_id = $user->device_id;
        $issue->device_token = $user->device_token;
        $issue->client_id = $user->client_id;
        $issue->start_date = date('Y-m-d');
        $issue->mobile_number = $request->input('mobile_number');
        $issue->save();
        session()->flash('success', 'Issue token raised successfully');
        return redirect()->route('issue_token');
    }

    public function admin_index()
    {
        $tech = tech_tokens::all();
        return view('frontend.admin.pages.tokens.index')->with(['tech' => $tech]);
    }

    public function add_index()
    {
        $type = issue_type::all();
        $client = clients::all();
        return view('frontend.admin.pages.tokens.add')->with(['type' => $type, 'client' => $client]);
    }

    public function type_index()
    {

        $data = issue_type::all();
        return view('frontend.admin.pages.tokens.type.index')->with(['data' => $data]);
    }

    public function assign_technical(Request $request)
    {
        $data = issue_token::where('id', $request->input('token2_id'))->first();
        if ($data == null) {
            Session::flash('error', 'No token fond');
            return redirect()->back();
        } else {
            tech_tokens::create([
                'token_id' => $data->id
            ]);
            Session::flash('success', 'Token assigned to technical team successfully');
            return redirect()->back();
        }
    }


    public function type_create(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'name' => 'unique:issue_types,name',
        ]);
        if ($validator->fails()) {
            Session::flash('error', $validator->errors());
            return redirect()->route('token-type');
        }
        $tok = new issue_type();
        $tok->create(['name' => $request->input('name')]);
        Session::flash('success', 'Token type created successfully');
        return redirect()->route('token-type');
    }

    public function type_delete(Request $request)
    {

        $type = issue_type::where('id', $request->input('row_id'))->first();
        $type->delete();
        $token = issue_token::where('issue_type', $request->input('row_id'))->first();
        if ($token != null) {
            $token->delete();
        }
        Session::flash('success', 'Token type deleted successfully');
        return redirect()->route('token-type');
    }

    public function fetch_device(Request $request)
    {
        $data = device::where('client_id', $request->input('client_id'))->get();
        return response()->json($data);
    }

    public function create_token_admin(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'type' => 'required',
            'client' => 'required',
            'device' => 'required',
            'description' => 'required',
            'mobile_number' => 'required'
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $device = device::where('device_id', $request->input('device'))->first();

        if ($request->input('start_date') == null) {
            $start_date = date('Y-m-d');
        } else {
            $start_date = $request->input('start_date');
        }

        $client_id = clients::where('mobile_number', $request->input('client'))->first();
        $issue = new issue_token();
        $issue->issue_type = $request->input('type');
        $issue->detail = $request->input('description');
        $issue->device_id = $request->input('device');
        $issue->device_token = $device->device_token;
        $issue->client_id = $client_id->client_id;
        $issue->start_date = $start_date;
        $issue->end_date = $request->input('end_date') ? $request->input('end_date') : null;
        $issue->mobile_number = $request->input('mobile_number');
        $issue->save();
        session()->flash('success', 'Issue token created successfully');
        return redirect()->route('/admin/tokens');
    }

    public function token_get($id)
    {
        $data = issue_token::where('id', $id)->first();
        $device = device::where('device_id', $data->device_id)->first();
        $type = issue_type::where('id', $data->issue_type)->first();

        $responseData = [
            'data' => $data,
            'device_name' => $device,
            'type' => $type,
        ];
        return response()->json($responseData);
    }

    public function token_update(Request $request)
    {
        $token = issue_token::where('id', $request->input('token_id'))->first();
        $token->update([
            'end_date' => $request->input('end_date'),
            'status' => $request->input('status'),
            'mobile_number' => $request->input('mobile_number'),
            'end_date' => $request->input('status') == 1 ? date('Y-m-d') : null,
        ]);
        session()->flash('success', 'Issue token updated successfully');
        return redirect()->route('/admin/tokens');
    }

    public function token_delete(Request $request)
    {
        $token = issue_token::where('id', $request->input('row_id'))->first();
        $token->delete();
        session()->flash('success', 'Issue token deleted successfully');
        return redirect()->route('/admin/tokens');
    }

    public function ajaxCallAllTokens(Request $request)
    {
        $params['draw'] = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $valueStatus = $request->input('status');
        $search_value = $request->input('search.value');

        if (!empty($search_value)) {
            $data1 = DB::table('clients')
                ->select('*')
                ->where('name', 'like', '%' . $search_value . '%')
                ->get();
            $data =  DB::table('issue_tokens')
                ->join('clients', 'issue_tokens.client_id', '=', 'clients.client_id')
                ->join('issue_types', 'issue_tokens.issue_type', '=', 'issue_types.id')
                ->select('issue_tokens.*', 'clients.name as client_name', 'issue_types.name as issue_type_name')
                ->whereIn('issue_tokens.client_id', $data1->pluck('client_id'))
                ->skip($start)
                ->take($length)
                ->get();
            $total_count = count($data);
        } elseif (!empty($valueStatus)) {
            $query = DB::table('issue_tokens')
                ->select('*')
                ->where('status', $valueStatus)
                ->get();

            $total_count = count($query);

            $data = DB::table('issue_tokens')
                ->join('clients', 'issue_tokens.client_id', '=', 'clients.client_id')
                ->join('issue_types', 'issue_tokens.issue_type', '=', 'issue_types.id')
                ->select('issue_tokens.*', 'clients.name as client_name', 'issue_types.name as issue_type_name')
                ->where('issue_tokens.status', $valueStatus)
                ->skip($start)
                ->take($length)
                ->get();
        } else {
            $total_count = count(DB::table('issue_tokens')->get());
            $data = DB::table('issue_tokens')
                ->join('clients', 'issue_tokens.client_id', '=', 'clients.client_id')
                ->join('issue_types', 'issue_tokens.issue_type', '=', 'issue_types.id')
                ->select('issue_tokens.*', 'clients.name as client_name', 'issue_types.name as issue_type_name')
                ->skip($start)
                ->take($length)
                ->get();
        }
        $type = issue_type::all();
        $client = clients::all();

        $json_data = [
            "draw" => intval($params['draw']),
            "recordsTotal" => $total_count,
            "recordsFiltered" => $total_count,
            "data" => $data,
            'type' => $type,
            'clients' => $client,
        ];
        return response()->json($json_data);
    }

    public function search_client(Request $request)
    {
        $data = clients::where('mobile_number', $request->input('client'))->first();
        return response()->json($data);
    }


    public function ajaxCallAllTokensTechnical(Request $request)
    {
        $params['draw'] = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $valueStatus = $request->input('status');
        $search_value = $request->input('search.value');

        if (!empty($search_value)) {
            $data1 = DB::table('clients')
                ->select('*')
                ->where('name', 'like', '%' . $search_value . '%')
                ->get();
            $data =  DB::table('issue_tokens')
                ->join('clients', 'issue_tokens.client_id', '=', 'clients.client_id')
                ->join('issue_types', 'issue_tokens.issue_type', '=', 'issue_types.id')
                ->select('issue_tokens.*', 'clients.name as client_name', 'issue_types.name as issue_type_name')
                ->whereIn('issue_tokens.client_id', $data1->pluck('client_id'))
                ->skip($start)
                ->take($length)
                ->get();
            $total_count = count($data);
        } elseif (!empty($valueStatus)) {
            $query = DB::table('issue_tokens')
                ->select('*')
                ->where('status', $valueStatus)
                ->get();

            $total_count = count($query);

            $data = DB::table('issue_tokens')
                ->join('clients', 'issue_tokens.client_id', '=', 'clients.client_id')
                ->join('issue_types', 'issue_tokens.issue_type', '=', 'issue_types.id')
                ->select('issue_tokens.*', 'clients.name as client_name', 'issue_types.name as issue_type_name')
                ->where('issue_tokens.status', $valueStatus)
                ->skip($start)
                ->take($length)
                ->get();
        } else {
            $total_count = count(DB::table('issue_tokens')->get());
            $tech_tokens = tech_tokens::all();
            $data = [];
            foreach ($tech_tokens as $tt) {
                $result = DB::table('issue_tokens')
                    ->join('clients', 'issue_tokens.client_id', '=', 'clients.client_id')
                    ->join('issue_types', 'issue_tokens.issue_type', '=', 'issue_types.id')
                    ->select('issue_tokens.*', 'clients.name as client_name', 'issue_types.name as issue_type_name')
                    ->where('issue_tokens.id', $tt->token_id)
                    ->skip($start)
                    ->take($length)
                    ->get();
                $data = array_merge($data, $result->toArray());
            }
        }
        $type = issue_type::all();
        $client = clients::all();
        $json_data = [
            "draw" => intval($params['draw']),
            "recordsTotal" => $total_count,
            "recordsFiltered" => $total_count,
            "data" => $data,
            'type' => $type,
            'clients' => $client,
        ];
        return response()->json($json_data);
    }
}
