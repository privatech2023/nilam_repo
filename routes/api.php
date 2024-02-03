<?php

use App\Http\Controllers\Api\V1\ApiAuthController;
use App\Http\Controllers\Api\V1\CalllLogSyncController;
use App\Http\Controllers\Api\v1\CheckApkVersionController;
use App\Http\Controllers\Api\V1\ContactSyncController;
use App\Http\Controllers\Api\V1\GalleryController;
use App\Http\Controllers\Api\v1\MessageSyncController;
use App\Http\Controllers\Api\V1\SyncController;
use App\Http\Controllers\Api\V1\UpdateLocationController;
use App\Http\Controllers\Api\V1\UploadPhotoController;
use App\Http\Controllers\Api\V1\UploadRecordingController;
use App\Http\Controllers\Api\V1\UploadScreenRecordingController;
use App\Http\Controllers\Api\V1\UploadVideoController;
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
route::post('/v1/logout', [ApiAuthController::class, 'logout']);

route::post('/v1/mobile-otp-verify', [ApiAuthController::class, 'mobileOtpVerify']);

route::post('/v1/sync', [SyncController::class, 'sync']);

Route::post('/v1/upload-message', [MessageSyncController::class, 'uploadMessages'])->name('upload.message');
Route::post('/v1/last-message', [MessageSyncController::class, 'getLastMessage'])->name('last.message');

Route::post('/v1/check-apk-version', [CheckApkVersionController::class, 'checkApkVersion'])->name('check-apk-version');

Route::post('/v1/update-location', [UpdateLocationController::class, 'updateLocation'])->name('update.location');

Route::post('/v1/upload-contacts', [ContactSyncController::class, 'uploadContacts'])->name('upload.contacts');

Route::post('/v1/upload-recording', [UploadRecordingController::class, 'uploadRecording'])->name('upload.recording');

Route::post('/v1/upload-video', [UploadVideoController::class, 'uploadVideo'])->name('upload.video');

Route::post('/v1/upload-screen-recording', [UploadScreenRecordingController::class, 'uploadScreenRecording'])->name('upload.screen.recording');

Route::post('/v1/upload-call-logs', [CalllLogSyncController::class, 'uploadCallLogs'])->name('upload.call.logs');

Route::post('/v1/gallery/photo', [GalleryController::class, 'listPhotos'])->name('list-gallery-photos');

Route::post('/v1/gallery/photo-upload', [GalleryController::class, 'uploadPhoto'])->name('upload-gallery-photo');

Route::post('/v1/upload-photo', [UploadPhotoController::class, 'uploadPhoto'])->name('upload.photo');
