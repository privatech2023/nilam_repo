<?php

namespace App\Http\Controllers;

use App\Models\coupons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class couponsController extends Controller
{
    public function index()
    {
        $data = coupons::all();
        return view('frontend.admin.pages.coupons.all_coupons', $data);
    }

    // AJAX Call All Coupons
    public function ajaxCallAllCoupons(Request $request)
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');

        $valueStatus = $request->input('status');
        $searchValue = $request->input('search.value');

        $query = coupons::select('*');

        if (!empty($searchValue)) {
            $query->where('coupon', 'like', '%' . $searchValue . '%');
            $total_count = coupons::where('coupon', 'like', '%' . $searchValue . '%')->count();
        } elseif (!empty($valueStatus)) {
            $query->where('is_active', $valueStatus);
            $total_count = coupons::where('is_active', $valueStatus)->count();
        } else {
            $total_count = coupons::count();
        }

        $data = $query->skip($start)->take($length)->get();

        $json_data = [
            'draw' => intval($draw),
            'recordsTotal' => $total_count,
            'recordsFiltered' => $total_count,
            'data' => $data->toArray(),
        ];

        return response()->json($json_data);
    }

    // Create New Coupon
    public function createCoupon(Request $request)
    {
        $validatedData =  Validator::make($request->all(), [
            'coupon_name' => 'required|alpha|unique:coupons,coupon',
            'promoter' => 'nullable|string',
            'discount_pcn' => 'required|numeric',
            'status' => 'required|numeric',
        ]);
        if ($validatedData->fails()) {
            Session::flash('error', $validatedData->errors());
            return redirect()->route('/admin/manageCoupons');
        }


        $coupon = new coupons();
        $coupon->coupon = strtoupper($request->input('coupon_name'));
        $coupon->promoter_name = $request->input('promoter');
        $coupon->discount_percentage = $request->input('discount_pcn');
        $coupon->is_active = $request->input('status');
        $coupon->created_by = session()->get('admin_id');
        $coupon->save();

        return redirect()->route('/admin/manageCoupons')->with('success', 'Coupon Created');
    }

    // Update Coupon
    public function updateCoupon(Request $request)
    {

        try {
            $id = $request->input('row_id');
            $validatedData =  Validator::make($request->all(), [
                'coupon_name' => 'required|string|unique:coupons,coupon',
                'promoter' => 'nullable|string',
                'discount_pcn' => 'required|numeric',
                'status' => 'required|numeric',
            ]);
            if ($validatedData->fails()) {
                Session::flash('error', $validatedData->errors());
                return redirect()->route('/admin/manageCoupons');
            }
            $coupon = coupons::where('cp_id', $id)->first();
            $coupon->coupon = strtoupper($request->input('coupon_name'));
            $coupon->promoter_name = $request->input('promoter');
            $coupon->discount_percentage = $request->input('discount_pcn');
            $coupon->is_active = $request->input('status');
            $coupon->save();


            return redirect()->route('/admin/manageCoupons')->with('success', 'Coupon Updated');
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'An error occurred. Please try again.'])->withInput();
        }
    }

    // Delete Coupon
    public function deleteCoupon(Request $request)
    {
        if ($request->filled('row_id')) {
            $id = $request->input('row_id');
            $coupon = coupons::find($id);
            $coupon->delete();

            return redirect()->route('/admin/manageCoupons')->with('success', 'Coupon Deleted');
        } else {
            return redirect()->route('/admin/manageCoupons')->with('error', 'Could not delete');
        }
    }
}
