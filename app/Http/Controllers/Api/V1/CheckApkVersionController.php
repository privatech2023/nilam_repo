<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\apk_versions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckApkVersionController extends Controller
{
    public function checkApkVersion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'apk_version' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Device apk version check failed',
                'errors' => (object)$validator->errors()->toArray(),
                'data' => (object)[],
            ], 422);
        }

        $data = $request->only(['apk_version']);

        $apkVersionModel = apk_versions::first();

        if ($apkVersionModel == null) {
            return response()->json([
                'status' => false,
                'message' => 'Not found',
                'errors' => (object)[],
                'data' => (object)[],
            ], 422);
        }

        if ($apkVersionModel->version > $data['apk_version']) {
            return response()->json([
                'status' => false,
                'message' => 'Update available',
                'errors' => (object)[],
                'data' => (object)[],
            ], 200);
        } else if ($apkVersionModel->version < $data['apk_version']) {
            return response()->json([
                'status' => false,
                'message' => 'Out of bounds',
                'errors' => (object)[],
                'data' => (object)[],
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Apk version ok',
            'errors' => (object)[],
            'data' => (object)[],
        ], 200);
    }
}
