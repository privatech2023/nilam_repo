<?php

namespace App\Http\Controllers;

use App\Models\settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class settingsController extends Controller
{
    private $db;

    // public function __construct()
    // {
    //     parent::__construct();
    //     $this->db = DB::connection()->getPdo();
    // }

    public function index()
    {
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
    }

    private function postChecker()
    {
        $model = new settings();

        if (\request()->isMethod('post')) {
            $updateData = [
                'id' => \request()->input('id'),
                'value' => \request()->input('value'),
            ];

            $model->update($updateData);

            session()->flash('success', 'Value Updated');
        }
    }
}
