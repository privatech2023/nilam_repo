<?php

namespace App\Http\Controllers;

use App\Models\defaultStorage;
use App\Models\storage;
use App\Models\storage_txn;
use App\Models\transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Razorpay\Api\Api as ApiApi;

class StorageController extends Controller
{
    public function index()
    {
        $default = defaultStorage::first();

        if ($default == null) {
            $default = 100;
        } else {
            $default = $default->storage;
        }
        $frontend = new frontendController;
        $data['gst_rate'] = $frontend->getSettings('gst_rate');
        return view('frontend.admin.pages.storage.index', $data)->with(['default_storage' => $default]);
    }

    public function frontend_index()
    {
        $storages = storage::where('status', 1)->get();
        return view('frontend.pages.storage.index')->with(['storages' => $storages]);
    }

    public function purchase($id)
    {
        $receipt = (string) str::uuid();

        $storage = storage::where('id', $id)->first();

        $amountInPaise = (int)($storage->price * 100);
        $api = new ApiApi(getenv('RAZORPAY_KEY'), getenv('RAZORPAY_SECRET'));
        $razorCreate = $api->order->create(array(
            'receipt' => $receipt,
            'amount' => $amountInPaise,
            'currency' => 'INR',
            'notes' => array('key1' => 'value1', 'key2' => 'value2', 'key3' => 'value3')
        ));

        $transaction = new transactions();
        $transaction->txn_id = $receipt;
        $transaction->client_id = session('user_id');
        $transaction->txn_type = 'Online payment';
        $transaction->txn_mode = 'Razorpay';
        $transaction->net_amount = $storage->amount;
        $transaction->tax_amt = $storage->tax;
        $transaction->paid_amt =  $storage->price;
        $transaction->plan_validity_days = $storage->plan_valdity == 'monthly' ? 30 : 365;
        $transaction->package_name = $storage->name;
        $transaction->activation_code = null;
        $transaction->status = 1;
        $transaction->price = $storage->price;
        $transaction->created_by = session()->get('user_id');
        $transaction->razorpay_order_id = $razorCreate->id;
        $transaction_id = $transaction->txn_id;
        $transaction->save();

        $subscription = new storage_txn();
        $subscription->client_id = session('user_id');
        $subscription->txn_id = $transaction_id;
        $subscription->status = 0;
        $subscription->plan_type = $storage->plan_validity;
        $subscription->storage = $storage->storage;
        $subscription->plan_id = $storage->id;
        $subscription->save();
        $data['razorPay'] = $razorCreate;
        return view('Frontend/razorpay/checkout', $data);
    }

    public function ajaxCallAllStorages(Request $request)
    {
        $params['draw'] = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $valueStatus = $request->input('status');
        $search_value = $request->input('search.value');
        if (!empty($search_value)) {
            $query = DB::table('storages')
                ->select('*')
                ->where('name', 'like', '%' . $search_value . '%')
                ->get();

            $total_count = count($query);

            $data = DB::table('storages')
                ->select('*')
                ->where('name', 'like', '%' . $search_value . '%')
                ->skip($start)
                ->take($length)
                ->get();
        } elseif (!empty($valueStatus)) {
            $query = DB::table('storages')
                ->select('*')
                ->where('status', $valueStatus)
                ->get();

            $total_count = count($query);

            $data = DB::table('storages')
                ->select('*')
                ->where('status', $valueStatus)
                ->skip($start)
                ->take($length)
                ->get();
        } else {
            $total_count = count(DB::table('storages')->get());
            $data = DB::table('storages')
                ->select('*')
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

    public function create_storage(Request $request)
    {
        $validatedData =  Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'storage' => 'required|numeric|min:0',
            'validity' => 'required',
            'amount' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'status' => 'required'
        ]);

        if ($validatedData->fails()) {
            Session::flash('error', $validatedData->errors());
            return redirect()->back();
        } else {
            $storage = new storage();
            $storage->create([
                'name' => $request->input('name'),
                'storage' => $request->input('storage'),
                'plan_validity' => $request->input('validity'),
                'amount' => $request->input('amount'),
                'tax' => $request->input('tax'),
                'price' => $request->input('price'),
                'status' => $request->input('status'),
            ]);
            Session::flash('success', 'Storage created successfully');
            return redirect()->route('/admin/manageStorage');
        }
    }

    public function delete_storage(Request $request)
    {
        if ($request->has('row_id')) {
            $id = $request->input('row_id');
            $storage = storage::find($id);
            if ($storage) {
                $storage->delete();
                Session::flash('success', 'Storage Deleted');
                return redirect()->route('/admin/manageStorage');
            } else {
                return response()->json(['error' => 'Package not found'], 404);
            }
        } else {
            return response()->json(['error' => 'Error occurred'], 500);
        }
    }

    public function default_storage(Request $request)
    {
        $validatedData =  Validator::make($request->all(), [
            'storage' => 'required|numeric|min:0',
        ]);

        if ($validatedData->fails()) {
            Session::flash('error', $validatedData->errors());
            return redirect()->back();
        } else {
            $storage = defaultStorage::first();
            if ($storage == null) {
                $storage_create = new defaultStorage();
                $storage_create->create([
                    'storage' => $request->input('storage')
                ]);
                Session::flash('success', 'Default storage created successfully');
                return redirect()->route('/admin/manageStorage');
            } else {
                $storage->update([
                    'storage' => $request->input('storage')
                ]);
                Session::flash('success', 'Default storage created successfully');
                return redirect()->route('/admin/manageStorage');
            }
        }
    }
}
