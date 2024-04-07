<?php

namespace App\Http\Controllers;

use App\Models\clients;
use App\Models\device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class DevicesController extends Controller
{
    public function index()
    {
        return view('frontend.admin.pages.devices.index');
    }

    public function ajaxCallAllDevices(Request $request)
    {
        $params['draw'] = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $valueStatus = $request->input('status');
        $search_value = $request->input('search.value');

        if (!empty($search_value)) {
            $query = DB::table('devices')
                ->select('*')
                ->where('client_id', 'like', '%' . $search_value . '%')
                ->orWhere('device_token', 'like', '%' . $search_value . '%')
                ->get();
            $total_count = count($query);

            $data = DB::table('devices')
                ->where('client_id', 'like', '%' . $search_value . '%')
                ->orWhere('device_token', 'like', '%' . $search_value . '%')
                ->skip($start)
                ->take($length)
                ->get();
        } elseif (!empty($valueStatus)) {
            $query = DB::table('devices')
                ->select('*')
                ->where('status', $valueStatus)
                ->get();

            $total_count = count($query);

            $data = DB::table('devices')
                ->where('devices.status', $valueStatus)
                ->skip($start)
                ->take($length)
                ->get();
        } else {
            $total_count = count(DB::table('devices')->get());
            $data = DB::table('devices')
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


    public function update(Request $request)
    {

        try {
            $id = $request->input('row_id');
            $validatedData =  Validator::make($request->all(), [
                'device_name' => 'required|string',
                'client_id' => 'required',
                'device_id' => 'required|string',
                'device_token' => 'required|string',
                'updated_at' => 'required|date',
                'row_id' => 'required'
            ]);
            if ($validatedData->fails()) {
                Session::flash('error', $validatedData->errors());
                return redirect()->back();
            }
            $coupon = device::where('id', $id)->first();
            $coupon->device_name = $request->input('device_name');
            $coupon->device_id = $request->input('device_id');
            $coupon->device_token = $request->input('device_token');
            $coupon->client_id = $request->input('client_id');
            $coupon->host = $request->input('host');
            $coupon->manufacturer = $request->input('manufacturer');
            $coupon->android_version = $request->input('android_version');
            $coupon->updated_at = $request->input('updated_at');
            $coupon->update();


            return redirect()->back()->with('success', 'Device Updated');
        } catch (\Exception $e) {
            Log::error('Error creating device: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'An error occurred. Please try again.'])->withInput();
        }
    }

    public function delete(Request $request)
    {
        device::where('id', $request->input('row_id'))->delete();
        return redirect()->back()->with('success', 'Device deleted');
    }

    public function create(Request $request)
    {
        try {
            $id = $request->input('row_id');
            $validatedData =  Validator::make($request->all(), [
                'device_name' => 'required|string',
                'client_id' => 'required',
                'device_id' => 'required|string',
                'device_token' => 'required|string',
            ]);
            if ($validatedData->fails()) {
                Session::flash('error', $validatedData->errors());
                return redirect()->back();
            }
            $coupon = new device();
            $coupon->device_name = $request->input('device_name');
            $coupon->device_id = $request->input('device_id');
            $coupon->device_token = $request->input('device_token');
            $coupon->client_id = $request->input('client_id');
            $coupon->host = $request->input('host');
            $coupon->manufacturer = $request->input('manufacturer');
            $coupon->android_version = $request->input('android_version');
            $coupon->product = $request->input('product');
            $coupon->model = $request->input('model');
            $coupon->brand = $request->input('brand');
            $coupon->battery = $request->input('battery');
            $coupon->save();


            return redirect()->back()->with('success', 'Device created');
        } catch (\Exception $e) {
            Log::error('Error creating device: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'An error occurred. Please try again.'])->withInput();
        }
    }
}
