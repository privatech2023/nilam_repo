<?php

namespace App\Http\Controllers;

use App\Models\backgroundImage;
use App\Models\default_client_creds;
use App\Models\settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class settingsController extends Controller
{
    public function index()
    {
        try {
            $data = [];
            $model = new settings();
            $this->postChecker();
            $settingsData = $model->get();
            if (!is_null($settingsData)) {
                $store = [];
                foreach ($settingsData as $valueSettings) {
                    if (!array_key_exists($valueSettings->key, $data)) {
                        $data['id'] = $valueSettings->id;
                        $data[$valueSettings->key] = $valueSettings->value;
                        $store[] = $data;
                    }
                }
                unset($settingsData);
            }
            $user = default_client_creds::first();
            $data = ['settings' => $store, 'user' => $user];
            return view('frontend.admin.settings', $data);
        } catch (\Exception $e) {
            Log::error('error: ' . $e->getMessage());
            $data = settings::all();
            $user = default_client_creds::first();
            session()->flash('error', $e->getMessage());
            return view('frontend.admin.settings', $data)->with(['data' => $data, 'user' => $user]);
        }
    }

    private function postChecker()
    {
        if (\request()->isMethod('post')) {
            $model = settings::find(\request()->input('id'));
            $updateData = [
                'value' => \request()->input('value'),
            ];
            $model->update($updateData);
            session()->flash('success', 'Value Updated');
        }
    }

    public function user_creds_update(Request $request)
    {
        $creds = default_client_creds::first();
        if ($creds == null) {
            $creds = new default_client_creds();
            $validatedData =  Validator::make($request->all(), [
                'password' => 'required|string',
            ]);
            if ($validatedData->fails()) {
                Session::flash('error', $validatedData->errors());
                return redirect()->route('settings_admin');
            }
            $creds->password = $request->input('password');
            $creds->save();
        } else {
            $creds->update([
                'password' => $request->input('password')
            ]);
            Session::flash('success', 'Client creds updated successfully');
            return redirect()->route('settings_admin');
        }
    }

    public function set_background(Request $request)
    {
        $bg = backgroundImage::first();
        if ($bg == null) {
            $new = new backgroundImage();
            $new->create([
                'url' => $request->input('imageUrl'),
                'client_id' => session('user_id')
            ]);
        } else {
            $new = new backgroundImage();
            $new->create([
                'url' => $request->input('imageUrl'),
                'client_id' => session('user_id')
            ]);
        }
        return response()->json('done');
    }
}
