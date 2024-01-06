<?php

namespace App\Http\Controllers;

use App\Models\clients;
use Illuminate\Http\Request;

class clientController extends Controller
{
    public function view_client($id)
    {
        $ClientModel = new clients();
        // $subsModel = new SubscriptionModel();
        // $txnModel = new TransactionModel();

        $data = array(
            'client_id' => $id,
            'subs_status' => '',
            'client_data' => $ClientModel->where('client_id', $id)->first(),
            'subscription_data' => '',
            'txn_data' => '',

        );

        return view('frontend.admin.pages.clients.view_client', $data);
    }
}
