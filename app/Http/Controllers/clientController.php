<?php

namespace App\Http\Controllers;

use App\Http\Controllers\frontend\subscriptionController;
use App\Models\clients;
use App\Models\subscriptions;
use App\Models\transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class clientController extends Controller
{
    public function view_client($id)
    {
        $ClientModel = new clients();
        $subsModel = new subscriptions();
        $txnModel = new transactions();
        $subs = new subscriptionController;
        $data = array(
            'client_id' => $id,
            'subs_status' => $subs->getSubStatus($id),
            'client_data' => $ClientModel->where('client_id', $id)->first(),
            'subscription_data' => $subsModel->where('client_id', $id)->first(),
            'txn_data' => $txnModel->where('client_id', $id)->get()->toArray(),
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
        $subsModel = new subscriptions();
        $txnModel = new transactions();
        $subs = new subscriptionController;
        $data = array(
            'client_id' => $request->input('row_id'),
            'subs_status' => $subs->getSubStatus($request->input('row_id')),
            'client_data' => $ClientModel->where('client_id', $request->input('row_id'))->first(),
            'subscription_data' => $subsModel->where('client_id', $request->input('row_id'))->first(),
            'txn_data' => $txnModel->where('client_id', $request->input('row_id'))->get()->toArray(),
        );
        session()->flash('success', 'Client updated successfully');
        return view('frontend.admin.pages.clients.view_client', $data);
    }

    public function update_client_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password'
        ]);
        if ($validator->fails()) {

            $ClientModel = new clients();
            $subsModel = new subscriptions();
            $txnModel = new transactions();
            $subs = new subscriptionController;
            $data = array(
                'client_id' => $request->input('row_id'),
                'subs_status' => $subs->getSubStatus($request->input('row_id')),
                'client_data' => $ClientModel->where('client_id', $request->input('row_id'))->first(),
                'subscription_data' => $subsModel->where('client_id', $request->input('row_id'))->first(),
                'txn_data' => $txnModel->where('client_id', $request->input('row_id'))->get()->toArray(),
            );
            session()->flash('error', $validator->errors());
            return view('frontend.admin.pages.clients.view_client', $data)->with(['error' => $validator->errors()]);
        } else {
            $client = clients::where('client_id', '=', $request->input('row_id'))->first();
            $client->password = bcrypt($request->input('password'));
            $client->save();
            session()->flash('success', 'Password updated successfully');

            $ClientModel = new clients();
            $subsModel = new subscriptions();
            $txnModel = new transactions();
            $subs = new subscriptionController;
            $data = array(
                'client_id' => $request->input('row_id'),
                'subs_status' => $subs->getSubStatus($request->input('row_id')),
                'client_data' => $ClientModel->where('client_id', $request->input('row_id'))->first(),
                'subscription_data' => $subsModel->where('client_id', $request->input('row_id'))->first(),
                'txn_data' => $txnModel->where('client_id', $request->input('row_id'))->get()->toArray(),
            );
            session()->flash('success', 'Password updated successfully');
            return view('frontend.admin.pages.clients.view_client', $data);
        }
    }

    public function profile_index()
    {
        $data = clients::where('client_id', session('user_id'))->first();
        return view('frontend.pages.profile.index')->with(['data' => $data]);
    }

    public function profile_update_frontend(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'password' => 'required|min:8',
                'confirm_password' => 'required|same:password'
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            } else {
                $client = clients::where('client_id', '=', session('user_id'))->first();
                $client->password = bcrypt($request->input('password'));
                $client->save();
                session()->flash('success', 'Password updated successfully');
                return redirect()->route('home');
            }
            return redirect()->route('profile');
        } catch (ValidationException $e) {

            return redirect()->route('home')->withErrors($e->errors())->withInput();
        }
    }

    public function default_device($id, $token)
    {
        $client = clients::where('client_id', session('user_id'))->first();
        $client->update(['device_id' => $id, 'device_token' => $token]);
        return redirect()->back()->with(['userId' => session('user_id')]);
    }
}
