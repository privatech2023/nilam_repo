<?php

namespace App\Http\Controllers;

use App\Models\apk_versions;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session as FacadesSession;
use Illuminate\Support\Facades\Validator;

class ApkVersionController extends Controller
{
    public function index()
    {
        $apk = apk_versions::first();
        if ($apk == null) {
            $apk['version'] = 0;
        }
        return view('frontend.admin.pages.apk-versions.index')->with(['apk' => $apk]);
    }

    public function create_update(Request $request)
    {
        $validatedData =  Validator::make($request->all(), [
            'apkVersion' => 'required|numeric|min:0',
        ]);
        if ($validatedData->fails()) {
            FacadesSession::flash('error', $validatedData->errors());
            return redirect()->route('apk-version');
        } else {
            $apk = apk_versions::first();
            if ($apk) {
                $apk->update([
                    'version' => $request->input('apkVersion'),
                ]);
            } else {
                $apk = apk_versions::create([
                    'version' => $request->input('apkVersion'),
                ]);
            }
            FacadesSession::flash('success', 'Apk version updated');
            return view('frontend.admin.pages.apk-versions.index')->with(['apk' => $apk]);
        }
    }
}
