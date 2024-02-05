<?php

namespace App\Http\Controllers;

use App\Models\packages;
use App\Models\settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{
    public function index()
    {
        $frontend = new frontendController;
        $data['gst_rate'] = $frontend->getSettings('gst_rate');

        $packages = packages::all();
        return view('frontend.admin.pages.packages.all_packages', $data)->with(['packages' => $packages]);
    }

    public function create(Request $request)
    {
        try {
            $validatedData =  Validator::make($request->all(), [
                'package_name' => 'required|string|max:255',
                'duration' => 'required|numeric|min:0',
                'amount' => 'required|numeric|min:0',
                'tax' => 'required|numeric|min:0',
                'price' => 'required|numeric|min:0',
                'status' => 'required|in:0,1',
            ]);
            if ($validatedData->fails()) {
                Session::flash('success', $validatedData->errors());
                return redirect()->route('/admin/managePackages');
            }
            $package = packages::create([
                'name' => $request->input('package_name'),
                'duration_in_days' => $request->input('duration'),
                'net_amount' => $request->input('amount'),
                'tax' => $request->input('tax'),
                'price' => $request->input('price'),
                'is_active' => $request->input('status'),
                'created_by' => session()->get('admin_id'),
            ]);
            Session::flash('success', 'Package Created');
            return redirect()->route('/admin/managePackages');
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'An error occurred. Please try again.'])->withInput();
        }
    }

    public function ajaxCallAllPackages(Request $request)
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $searchValue = $request->input('search.value');
        $valueStatus = $request->input('status');

        $query = packages::select('*');

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

    public function updatePackage(Request $request)
    {
        $id = $request->input('row_id');

        // Validation passed, update the record
        $package = packages::find($id);
        $package->name = strtoupper($request->input('package_name'));
        $package->duration_in_days = $request->input('duration');
        $package->net_amount = $request->input('amount');
        $package->tax = $request->input('tax');
        $package->price = $request->input('price');
        $package->is_active = $request->input('status');
        $package->save();

        Session::flash('success', 'Package Updated');
        return redirect()->route('/admin/managePackages');
    }

    public function deletePackage(Request $request)
    {
        if ($request->has('row_id')) {
            $id = $request->input('row_id');
            $package = packages::find($id);
            if ($package) {
                Session::flash('success', 'Package Deleted');
                return redirect()->route('/admin/managePackages');
            } else {
                return response()->json(['error' => 'Package not found'], 404);
            }
        } else {
            return response()->json(['error' => 'Error occurred'], 500);
        }
    }
}
