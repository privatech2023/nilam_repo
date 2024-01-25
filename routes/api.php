<?php

use App\Http\Controllers\Api\V1\ApiAuthController;
use App\Http\Controllers\Api\v1\CheckApkVersionController;
use App\Http\Controllers\Api\v1\MessageSyncController;
use App\Http\Controllers\Api\V1\SyncController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

route::post('/v1/mobile-otp', [ApiAuthController::class, 'mobileOtp']);
route::post('/v1/email-login', [ApiAuthController::class, 'emailLogin']);

route::post('v1/mobile-otp-verify', [ApiAuthController::class, 'mobileOtpVerify']);

route::post('v1/sync', [SyncController::class, 'sync']);

Route::post('v1/upload-message', [MessageSyncController::class, 'uploadMessages'])->name('upload.message');
Route::post('v1/last-message', [MessageSyncController::class, 'getLastMessage'])->name('last.message');

Route::post('/check-apk-version', [CheckApkVersionController::class, 'checkApkVersion'])->name('check-apk-version');
