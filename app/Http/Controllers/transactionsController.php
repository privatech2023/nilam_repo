<?php

namespace App\Http\Controllers;

use App\Models\transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class transactionsController extends Controller
{
    public function index()
    {
        $data = array();
        return view('frontend.admin.pages.transactions.index', $data);
    }

    // AJAX Call all TXN
    public function ajaxCallAllTxn()
    {
        try {
            $params['draw'] = request('draw');
            $start = request('start');
            $length = request('length');

            $total_count = array();
            $data = array();

            $valueStatus = request('status', '');

            $search_value = request('search.value', '');

            if (!empty($search_value)) {
                $query = transactions::select('transactions.*', 'clients.name', 'clients.mobile_number')
                    ->join('clients', 'transactions.client_id', '=', 'clients.client_id')
                    ->where('transactions.txn_id', 'like', '%' . $search_value . '%')
                    ->orderBy('transactions.updated_at', 'DESC');
                $total_count = $query->get();
                $data = $query->skip($start)->take($length)->get();
            } elseif (!empty($valueStatus)) {
                $query = transactions::select('transactions.*', 'clients.name', 'clients.mobile_number')
                    ->join('clients', 'transactions.client_id', '=', 'clients.client_id')
                    ->where('transactions.status', $valueStatus)
                    ->orderBy('transactions.updated_at', 'DESC');
                $total_count = $query->get();
                $data = $query->skip($start)->take($length)->get();
            } else {
                $query = transactions::select('transactions.*', 'clients.name', 'clients.mobile_number')
                    ->join('clients', 'transactions.client_id', '=', 'clients.client_id')
                    ->orderBy('transactions.updated_at', 'DESC');
                $total_count = $query->get();
                $data = $query->skip($start)->take($length)->get();
            }

            $json_data = array(
                "draw" => intval($params['draw']),
                "recordsTotal" => count($total_count),
                "recordsFiltered" => count($total_count),
                "data" => $data
            );
            return response()->json($json_data);
        } catch (\Exception $e) {
            Log::error('error: ' . $e->getMessage());
        }
    }
}
