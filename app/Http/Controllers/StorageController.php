<?php

namespace App\Http\Controllers;

use App\Models\clients;
use App\Models\defaultStorage;
use App\Models\gallery_items;
use App\Models\images;
use App\Models\recordings;
use App\Models\screen_recordings;
use App\Models\storage;
use App\Models\storage_txn;
use App\Models\transactions;
use App\Models\videos;
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
        $transaction->storage_id = $storage->id;
        $transaction->storage_name = $storage->name;
        $transaction->package_name = 'Storage';
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
        return view('frontend/razorpay/checkout', $data);
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

    // admin storage view
    public function storage_usage_index()
    {
        dd('0001');
        return view('frontend.admin.pages.storage.client.index');
    }

    public function ajaxCallAllClientsStorage(Request $request)
    {
        $draw = request('draw');
        $start = request('start');
        $length = request('length');
        $searchValue = request('search.value', '');
        $valueStatus = request('status', '');
        $valueRegistration = request('registration', '');


        $latestTransactionIds = DB::table('storage_txns as st1')
            ->select(DB::raw('MAX(st1.id) as id'))
            ->groupBy('st1.client_id');

        // Main query using the subquery
        $query = DB::table('storage_txns')
            ->select('clients.client_id', 'clients.name', 'storage_txns.created_at', 'clients.mobile_number', 'storage_txns.status', 'storage_txns.storage', 'storages.name as storage_name', 'storages.plan_validity as validity')
            ->join('clients', 'clients.client_id', '=', 'storage_txns.client_id')
            ->leftJoin('storages', 'storages.id', '=', 'storage_txns.plan_id')
            ->whereIn('storage_txns.id', $latestTransactionIds)
            ->orderByDesc('storage_txns.updated_at');



        if (!empty($searchValue)) {
            $query->where(function ($query) use ($searchValue) {
                if (ctype_digit($searchValue)) {
                    $query->where('clients.mobile_number', 'like', '%' . $searchValue . '%');
                } else {
                    $query->where('clients.name', 'like', '%' . $searchValue . '%');
                }
            });
        }

        if (!empty($valueStatus)) {
            $query->where('clients.status', $valueStatus);
        }

        if (!empty($valueRegistration)) {
            $valueRegistration = date('Y-m-d', strtotime($valueRegistration));
            $query->whereDate('subscriptions.updated_at', $valueRegistration);
        }
        $total_count = $query->count();
        $data = $query->skip($start)->take($length)->get();
        $json_data = [
            "draw" => intval($draw),
            "recordsTotal" => $total_count,
            "recordsFiltered" => $total_count,
            "data" => $data,
        ];
        return response()->json($json_data);
    }

    public function storage_usage_view()
    {

        try {
            $gall_size = 0;
            $photo_size = 0;
            $video_size = 0;
            $screenRecord_size = 0;
            $voiceRecord_size = 0;

            try {
                $gallery = DB::table('gallery_items')->get();
                dd($gallery);
            } catch (\Exception $e) {
                dd($e->getMessage());
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        foreach ($gallery as $g) {
            $gall_size += $g->size;
        }
        $gall_size = number_format($gall_size / (1024 * 1024));
        $images = images::all();
        foreach ($images as $g) {
            $photo_size += $g->size;
        }
        $photo_size = number_format($photo_size / (1024 * 1024));
        $videos = videos::all();
        foreach ($videos as $g) {
            $video_size += $g->size;
        }
        $video_size = number_format($video_size / (1024 * 1024));
        $screen_record = screen_recordings::all();
        foreach ($screen_record as $g) {
            $screenRecord_size += $g->size;
        }
        $screenRecord_size = number_format($screenRecord_size / (1024 * 1024));
        $voice_record = recordings::all();
        foreach ($voice_record as $g) {
            $voiceRecord_size += $g->size;
        }
        $voiceRecord_size = number_format($voiceRecord_size / (1024 * 1024));

        return view('frontend.admin.pages.storage.client.view')->with([
            'gallery' => $gallery,
            'images' => $images,
            'videos' => $videos,
            'screen_record' => $screen_record,
            'voice_record' => $voice_record,
            'gall_size' => $gall_size,
            'photo_size' => $photo_size,
            'video_size' => $video_size,
            'screenRecord_size' => $screenRecord_size,
            'voiceRecord_size' => $voiceRecord_size,
        ]);
    }

    public function storage_usage_view_main($type)
    {
        if ($type == 'gallery') {
            $data = gallery_items::all();
        } elseif ($type == 'videos') {
            $data = videos::all();
        } elseif ($type == 'screen_record') {
            $data = screen_recordings::all();
        } elseif ($type == 'voice_record') {
            $data = recordings::all();
        } else {
            $data = images::all();
        }
        return view('frontend.admin.pages.storage.client.main')->with(['data' => $data, 'type' => $type]);
    }

    public function storage_usage_view_client($id, $type)
    {
        $client = clients::where('client_id', $id)->first();
        if ($type == 'gallery') {
            $data = gallery_items::where('user_id', $id)->get();
        } elseif ($type == 'photos') {
            $data = images::where('user_id', $id)->get();
        } elseif ($type == 'videos') {
            $data = videos::where('user_id', $id)->get();
        } elseif ($type == 'screen_record') {
            $data = screen_recordings::where('user_id', $id)->get();
        } else {
            $data = recordings::where('user_id', $id)->get();
        }
        return view('frontend.admin.pages.storage.client.user_media')->with(['data' => $data, 'type' => $type, 'client' => $client]);
    }
}
