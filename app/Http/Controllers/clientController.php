<?php

namespace App\Http\Controllers;

use App\Models\clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class clientController extends Controller
{
    public function view_client($id)
    {
        $ClientModel = new clients();

        $data = array(
            'client_id' => $id,
            'subs_status' => '',
            'client_data' => $ClientModel->where('client_id', $id)->first(),
            'subscription_data' => '',
            'txn_data' => '',
        );

        return view('frontend.admin.pages.clients.view_client', $data);
    }

    public function update_client(Request $request)
    {
        $client = clients::where('client_id', '=', $request->input('row_id'))->first();
        $client->name = $request->input('name');
        $client->email = $request->input('email');
        $client->mobile_number = $request->input('mobile');
        $client->status = $request->input('status');
        $client->save();

        $ClientModel = new clients();
        $data = array(
            'client_id' => $client->client_id,
            'subs_status' => '',
            'client_data' => $ClientModel->where('client_id', $client->client_id)->first(),
            'subscription_data' => '',
            'txn_data' => '',
        );
        session()->flash('success', 'Client updated');
        return view('frontend.admin.pages.clients.view_client', $data)->with(['success' => "Client updated successfully"]);
    }

    public function update_client_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password'
        ]);
        if ($validator->fails()) {
            session()->flash('error', $validator->errors());

            $ClientModel = new clients();

            $data = array(
                'client_id' => $request->input('row_id'),
                'subs_status' => '',
                'client_data' => $ClientModel->where('client_id', $request->input('row_id'))->first(),
                'subscription_data' => '',
                'txn_data' => '',
            );

            return view('frontend.admin.pages.clients.view_client', $data)->with(['error' => $validator->errors()]);
        } else {
            $client = clients::where('client_id', '=', $request->input('row_id'))->first();
            $client->password = bcrypt($request->input('password'));
            $client->save();
            session()->flash('success', 'Password updated successfully');

            $ClientModel = new clients();

            $data = array(
                'client_id' => $request->input('row_id'),
                'subs_status' => '',
                'client_data' => $ClientModel->where('client_id', $request->input('row_id'))->first(),
                'subscription_data' => '',
                'txn_data' => '',
            );

            return view('frontend.admin.pages.clients.view_client', $data)->with(['data' => $data, 'success' => "Password updated successfully"]);
        }
    }
}
