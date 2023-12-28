<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    Session::forget('user_data');
    return view('frontend/pages/index');
});

route::get('login/client', function () {
    return view('frontend/auth/login');
})->name('login');

route::get('register/client', function () {
    return view('frontend/auth/register');
});

route::post('login/client', [LoginController::class, 'login']);

route::get('client/logout', [LoginController::class, 'logout']);

route::post('register/client', [RegisterController::class, 'create_user']);

route::post('check/client', [LoginController::class, 'check_client']);
Route::post('/login_options/client/', [LoginController::class, 'login_options']);
Route::get('/login_options/client', [LoginController::class, 'login_options_index']);
route::get('login_password/client', function () {
    return view('frontend.auth.login_password');
});
route::post('login/password/client', [LoginController::class, 'login_with_password']);
route::get('get_otp/client', [LoginController::class, 'generate_otp']);
route::post('login_otp/client', [LoginController::class, 'login_otp']);


//client middleware, not used yet.
Route::group(['middleware' => 'client.auth'], function () {
});
