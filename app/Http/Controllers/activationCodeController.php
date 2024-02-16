<?php

namespace App\Http\Controllers;

use App\Models\activation_codes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class activationCodeController extends Controller
{
    public function index()
    {
        $frontend = new frontendController;
        $data['gst_rate'] = $frontend->getSettings('gst_rate');
        return view('frontend.admin.pages.activation_codes.all_activation_codes', $data);
    }
    public function ajaxCallAllCodes(Request $request)
    {
        $params['draw'] = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $valueStatus = $request->input('status');
        $search_value = $request->input('search.value');

        if (!empty($search_value)) {
            $query = DB::table('activation_codes')
                ->select('*')
                ->where('code', 'like', '%' . $search_value . '%')
                ->get();

            $total_count = count($query);

            $data = DB::table('activation_codes')
                ->select('*')
                ->where('code', 'like', '%' . $search_value . '%')
                ->skip($start)
                ->take($length)
                ->get();
        } elseif (!empty($valueStatus)) {
            $query = DB::table('activation_codes')
                ->select('*')
                ->where('is_active', $valueStatus)
                ->get();

            $total_count = count($query);

            $data = DB::table('activation_codes')
                ->select('*')
                ->where('is_active', $valueStatus)
                ->skip($start)
                ->take($length)
                ->get();
        } else {
            $total_count = count(DB::table('activation_codes')->get());
            $data = DB::table('activation_codes')
                ->select('activation_codes.*', 'clients.name as client_name')
                ->leftJoin('clients', 'activation_codes.used_by', '=', 'clients.client_id')
                ->skip($start)
                ->take($length)
                ->get();
        }
        $json_data = [
            "draw" => intval($params['draw']),
            "recordsTotal" => $total_count,
            "recordsFiltered" => $total_count,
            "data" => $data,
        ];

        return response()->json($json_data);
    }

    public function createCode(Request $request)
    {
        try {
            $rules = [
                'code_name' => 'required|unique:activation_codes,code',
                'duration' => 'required|numeric',
                'amount' => 'required|numeric',
                'tax' => 'required|numeric',
                'expiry_date' => 'required',
                'price' => 'required|numeric',
                'status' => 'required|numeric',
                'devices' => 'required'
            ];
            $messages = [
                'code_name.required' => 'Code is required',
                'code_name.alpha_dash' => 'Code should only contain letters, numbers, dashes, and underscores.',
                'code_name.unique' => 'Code already exists',
            ];
            $this->validate($request, $rules, $messages);
            $data = [
                'code' => strtoupper($request->input('code_name')),
                'duration_in_days' => $request->input('duration'),
                'net_amount' => $request->input('amount'),
                'tax' => $request->input('tax'),
                'price' => $request->input('price'),
                'expiry_date' => $request->input('expiry_date'),
                'is_active' => $request->input('status'),
                'devices' => $request->input('devices'),
                'created_by' => session()->get('admin_id'),
            ];
            activation_codes::create($data);
            Session::flash('success', 'Code Created');
            return redirect()->route('/admin/activationCodes');
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'An error occurred. Please try again.'])->withInput();
        }
    }


    public function updateCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code_name' => 'required',
            'duration' => 'required|numeric',
            'amount' => 'required|numeric',
            'tax' => 'required|numeric',
            'expiry_date' => 'required',
            'price' => 'required|numeric',
            'status' => 'required|numeric',
            'devices' => 'required'
        ]);
        if ($validator->fails()) {
            Session::flash('error', $validator->errors());
            return redirect()->route('/admin/activationCodes');
        }
        $data = activation_codes::where('c_id', $request->input('c_id'))->first();
        $data->update([
            'code' => $request->input('code_name'),
            'duration_in_' => $request->input('duration'),
            'duration_in_days' => $request->input('duration'),
            'net_amount' => $request->input('amount'),
            'tax' => $request->input('tax'),
            'expiry_date' => $request->input('expiry_date'),
            'price' => $request->input('price'),
            'is_active' => $request->input('status'),
            'devices' => $request->input('devices')
        ]);
        Session::flash('success', 'Activation code updated successfully');
        return redirect()->route('/admin/activationCodes');
    }

    public function deleteCode(Request $request)
    {
        if ($request->filled('row_id')) {
            $id = $request->input('row_id');
            $code = activation_codes::find($id);
            $code->delete();

            Session::flash('success', 'Code Deleted');
            return redirect()->route('/admin/activationCodes');
        } else {
            $errorMsg = ['Msg' => 'Error occurred!'];
            Session::flash('error', $errorMsg);
            return redirect()->route('/admin/activationCodes');
        }
    }
}
