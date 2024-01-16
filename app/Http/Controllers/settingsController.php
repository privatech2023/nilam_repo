<?php

namespace App\Http\Controllers;

use App\Models\settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            $data = ['settings' => $store];

            return view('frontend.admin.settings', $data);
        } catch (\Exception $e) {
            Log::error('error: ' . $e->getMessage());
            $data = settings::all();
            session()->flash('error', $e->getMessage());
            return view('frontend.admin.settings', $data);
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
}
