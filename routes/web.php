<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\rolesController;
use App\Http\Controllers\subscriptionController;
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

route::get('login/client', [LoginController::class, 'index'])->name('login');

route::get('register/client', [RegisterController::class, 'index']);

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



//admin
route::get('/admin/login', [adminController::class, 'login_index']);

route::post('/admin/login', [adminController::class, 'login']);
route::get('/admin/logout', [adminController::class, 'logout']);

Route::group(['middleware' => 'user.auth'], function () {
    route::get('/admin', [adminController::class, 'index'])->name('/admin');
    route::get('/admin/roles', [adminController::class, 'roles'])->name('/admin/roles');
    route::get('/admin/create-roles', [adminController::class, 'create_roles'])->name('/admin/create-roles');
    route::post('/admin/create-roles', [rolesController::class, 'create_roles']);
    route::post('/admin/delete-roles', [rolesController::class, 'delete_roles']);

    route::get('/admin/subscription/index', [subscriptionController::class, 'index']);
    route::get('/admin/subscription/active', [subscriptionController::class, 'active']);
    route::get('/admin/subscription/pending', [subscriptionController::class, 'pending']);
    route::get('/admin/subscription/expired', [subscriptionController::class, 'expired']);
});
