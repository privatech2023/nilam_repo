<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\clientController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\rolesController;
use App\Http\Controllers\subscriptionController;
use App\Http\Controllers\usersController;
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
route::get('login_otp/client', [LoginController::class, 'index_otp'])->name('login_otp/client');
route::post('login_otp/client', [LoginController::class, 'login_otp']);

route::get('login/forgot-password', [LoginController::class, 'forgot_password']);
route::post('login/reset-password', [LoginController::class, 'reset_password']);
//client middleware, not used yet.
Route::group(['middleware' => 'client.auth'], function () {
});



//admin
route::get('/admin/login', [adminController::class, 'login_index']);

route::post('/admin/login', [adminController::class, 'login']);
route::get('/admin/logout', [adminController::class, 'logout']);

Route::group(['middleware' => 'user.auth'], function () {
    route::get('/admin', [adminController::class, 'index'])->name('/admin');

    route::group(['middleware' => 'roles.permission'], function () {
        route::get('/admin/roles', [adminController::class, 'roles'])->name('/admin/roles');
        route::get('/admin/create-roles', [adminController::class, 'create_roles'])->name('/admin/create-roles');
        route::post('/admin/create-roles', [rolesController::class, 'create_roles']);
        route::post('/admin/delete-roles', [rolesController::class, 'delete_roles']);
        route::get('/admin/roles/update/{id}', [rolesController::class, 'update_roles_index']);
        route::post('/admin/roles/update', [rolesController::class, 'update_roles']);
    });

    route::get('/admin/subscription/index', [subscriptionController::class, 'index'])->name('all_client');
    route::get('/admin/subscription/active', [subscriptionController::class, 'active']);
    route::get('/admin/subscription/pending', [subscriptionController::class, 'pending']);
    route::get('/admin/subscription/expired', [subscriptionController::class, 'expired']);

    route::get('/admin/view-client/{id}', [clientController::class, 'view_client'])->name('view_client');

    route::get('/admin/users', [usersController::class, 'index'])->name('admin_users');
    route::get('/admin/users/add', [usersController::class, 'add_user_index']);
    route::post('/admin/users/create', [usersController::class, 'create_user']);
    route::get('/admin/user/update/{id}', [usersController::class, 'update_index']);
    route::post('/admin/user/update/', [usersController::class, 'update_user']);

    route::post('/admin/delete/user', [usersController::class, 'delete_user']);

    route::post('/admin/client/update', [clientController::class, 'update_client']);
    route::post('admin/clients/updatePassword', [clientController::class, 'update_client_password']);
});
