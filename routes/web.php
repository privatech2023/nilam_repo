<?php

use App\Http\Controllers\Actions\Functions\SendFcmNotification as FunctionsSendFcmNotification;
use App\Http\Controllers\activationCodeController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\Api\V1\ApiAuthController;
use App\Http\Controllers\ApkVersionController;
use App\Http\Controllers\DeleteController;
use App\Http\Controllers\clientController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\couponsController;
use App\Http\Controllers\DevicesController;
use App\Http\Controllers\EarningsController;
use App\Http\Controllers\Features\BackgroundGalleryController;
use App\Http\Controllers\Features\CallLogController;
use App\Http\Controllers\Features\CameraController;
use App\Http\Controllers\Features\ContactsController;
use App\Http\Controllers\Features\IndexController;
use App\Http\Controllers\Features\MessageController as FeaturesMessageController;
use App\Http\Controllers\Features\ScreenRecordController;
use App\Http\Controllers\Features\VoiceRecordController;
use App\Http\Controllers\FeaturesController;
use App\Http\Controllers\frontend\messageController;
use App\Http\Controllers\frontend\subscriptionController as FrontendSubscriptionController;
use App\Http\Controllers\frontendController;
use App\Http\Controllers\issueTokenController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ManualTransactions;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\rolesController;
use App\Http\Controllers\SendFcmNotification;
use App\Http\Controllers\settingsController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\subscriptionController;
use App\Http\Controllers\transactionsController;
use App\Http\Controllers\UplineController;
use App\Http\Controllers\usersController;
use App\Http\Livewire\AlertDeviceComponent;
use App\Http\Livewire\AudioRecordComponent;
use App\Http\Livewire\CallLogComponent;
use App\Http\Livewire\CameraComponent;
use App\Http\Livewire\ContactsComponent;
use App\Http\Livewire\FilemanagerComponent;
use App\Http\Livewire\GalleryComponent;
use App\Http\Livewire\LocatePhone;
use App\Http\Livewire\LostMessagesComponent;
use App\Http\Livewire\MessageComponent;
use App\Http\Livewire\MessagePopulate;
use App\Http\Livewire\MyDevices;
use App\Http\Livewire\ScreenRecordComponent;
use App\Http\Livewire\TextToSpeech;
use App\Http\Livewire\VibrateComponent;
use App\Http\Livewire\VideoRecordComponent;
use App\Models\settings;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/login', function () {
    return redirect()->route('login');
});

Route::get('/register', function () {
    return redirect()->route('register/client');
});

Route::get('/', [frontendController::class, 'home'])->name('home');

Route::get('login/client', [LoginController::class, 'index'])->name('login');

Route::get('register/client', [RegisterController::class, 'index'])->name('register/client');

Route::post('login/client', [LoginController::class, 'login']);

Route::get('client/logout', [LoginController::class, 'logout']);

Route::post('register/client', [RegisterController::class, 'create_user']);

Route::post('check/client', [LoginController::class, 'check_client']);
Route::post('/login_options/client/', [LoginController::class, 'login_options']);
Route::get('/login_options/client', [LoginController::class, 'login_options_index']);
Route::get('login_password/client', function () {
    return view('frontend.auth.login_password');
});
Route::post('login/password/client', [LoginController::class, 'login_with_password']);
Route::get('get_otp/client', [LoginController::class, 'generate_otp']);
Route::get('login_otp/client', [LoginController::class, 'index_otp'])->name('login_otp/client');
Route::post('login_otp/client', [LoginController::class, 'login_otp']);

Route::get('login/forgot-password', [LoginController::class, 'forgot_password']);
Route::post('login/reset-password', [LoginController::class, 'reset_password']);

Route::get('/public/packages', function () {
    return redirect()->route('/subscription/packages');
});

route::get('/log', function () {
    $logFile = storage_path('logs/laravel.log');
    if (File::exists($logFile)) {
        try {
            $logs = File::get($logFile);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        $logs = explode("\n", $logs);
    } else {
        $logs = ['Log file not found.'];
    }
    return view('frontend.admin.pages.logs', ['logs' => $logs]);
});


Route::get('/log/clear', function () {
    $logFilePath = storage_path('logs/laravel.log');

    if (File::exists($logFilePath)) {
        File::put($logFilePath, '');
        return redirect()->back();
    } else {
        return redirect()->back();
    }
});

Route::post('/payment/razorpay/webhook', [RazorpayController::class, 'webhook'])->name('razorpay.payment.webhook');
// client
Route::group(['middleware' => 'client.auth'], function () {
    Route::get('/subscription', [FrontendSubscriptionController::class, 'index'])->name('/subscription/packages');
    // Route::get('/subscription/packages', [FrontendSubscriptionController::class, 'packages'])->name('/subscription/packages');
    Route::get('/subscription/purchase/{id}', [FrontendSubscriptionController::class, 'purchasePackage'])->name('purchase.package');
    Route::post('/subscription/pay', [FrontendSubscriptionController::class, 'checkout_activation_code']);

    Route::get('/razorpay/pay', [RazorpayController::class, 'pay'])->name('razorpay.payment.pay');
    Route::get('/razorpay/success', [RazorpayController::class, 'success'])->name('razorpay.payment.success');

    Route::post('/razorpay/success/storage', [RazorpayController::class, 'success_storage'])->name('razorpay.payment.success.storage');

    Route::post('/subscription/checkout', [FrontendSubscriptionController::class, 'checkout']);
    // Route::post('/subscription/checkout/webhook', [FrontendSubscriptionController::class, 'webhook']);
    Route::get('/storage-plan', [StorageController::class, 'frontend_index']);
    Route::get('/storage-plan/purchase/{id}', [StorageController::class, 'purchase']);

    Route::post('/onlinePayment', [FrontendSubscriptionController::class, 'onlinePayment']);

    // Route::post('/messages', [messageController::class, 'index'])->name('/messages');

    Route::get('/profile', [clientController::class, 'profile_index'])->name('profile');
    Route::post('/profile-update', [clientController::class, 'profile_update_frontend']);

    Route::get('/issue-token', [issueTokenController::class, 'index'])->name('issue_token');
    Route::post('/raise-issue', [issueTokenController::class, 'create']);

    Route::get('/get/device/{id}', [frontendController::class, 'get_devices']);

    // features
    Route::group(['middleware' => 'client.validity'], function () {
        Route::post('/delete/image', [DeleteController::class, 'destroy_camera']);
        Route::post('/delete/gallery', [DeleteController::class, 'destroy_gallery']);
        Route::post('/delete/video', [DeleteController::class, 'destroy_video']);
        Route::post('/delete/audio', [DeleteController::class, 'destroy_audio']);
        Route::post('/delete/screen-record', [DeleteController::class, 'destroy_screen_recording']);
        Route::post('/delete/call-record', [DeleteController::class, 'destroy_call_record']);

        // Route::get('/message/{userId}', MessageComponent::class)->name('messages');
        // Route::get('/contacts/{userId}', ContactsComponent::class)->name('contacts');
        // Route::get('/camera/{userId}', CameraComponent::class)->name('camera');
        // Route::get('/call-log/{userId}', CallLogComponent::class)->name('call-log');
        // Route::get('/audio-record/{userId}', AudioRecordComponent::class)->name('audio-record');
        // Route::get('/alert-device/{userId}', AlertDeviceComponent::class);
        // Route::get('/vibrate-device/{userId}', VibrateComponent::class);
        // Route::get('/screen-record/{userId}', ScreenRecordComponent::class)->name('screen-record');
        // Route::get('/video-record/{userId}', VideoRecordComponent::class)->name('video');
        // Route::get('/gallery/{userId}', GalleryComponent::class)->name('gallery');
        // Route::get('/filemanager/{userId}', FilemanagerComponent::class);
        // Route::get('/lost-messages/{userId}', LostMessagesComponent::class);
        // Route::get('/locate-phone/{userId}', LocatePhone::class);
        // Route::get('/text-to-speech/{userId}', TextToSpeech::class);
        // Route::get('/my-devices/{userId}', MyDevices::class);

        // Route::get('/message-populate/{key}', MessagePopulate::class)->name('message-populate');
        Route::get('/default-device/{id}', [clientController::class, 'default_device']);

        // features new template 
        Route::get('/messages', [IndexController::class, 'messages']);
        Route::get('/messages/{id}', [FeaturesMessageController::class, 'get_messages']);
        Route::get('/messageView/{id}', [FeaturesMessageController::class, 'get_messagesView']);

        Route::get('/call-logs', [IndexController::class, 'call_logs']);
        Route::get('/get-call-logs/{id}', [CallLogController::class, 'get_call_logs']);

        Route::get('/contacts', [IndexController::class, 'contacts']);
        Route::get('/get-contacts/{id}', [ContactsController::class, 'get_contacts']);

        Route::get('/gallery', [IndexController::class, 'gallery']);

        Route::get('/voice-record', [IndexController::class, 'voice_record']);
        Route::get('/voice-record/{id}', [VoiceRecordController::class, 'get_voice_record']);
        Route::get('/record-voice/{id}', [VoiceRecordController::class, 'record_voice']);

        Route::get('/camera', [IndexController::class, 'camera']);
        Route::get('/camera-front', [IndexController::class, 'camera_front']);
        Route::get('/camera/take-picture', [CameraController::class, 'take_picture']);
        Route::get('/camera-back', [IndexController::class, 'camera_back']);
        Route::get('/camera/take-picture/back', [CameraController::class, 'take_picture_back']);

        Route::get('/video-front', [IndexController::class, 'video_front']);
        Route::get('/video-back', [IndexController::class, 'video_back']);
        Route::get('/camera/take-video', [CameraController::class, 'take_video']);
        Route::get('/camera/take-video-back', [CameraController::class, 'take_video_back']);

        Route::get('/device-status', [IndexController::class, 'device_status']);
        Route::get('/device-status/get-status', [IndexController::class, 'get_device_status']);

        Route::get('/screen-record', [IndexController::class, 'screen_record']);
        Route::get('/screen-record/new', [IndexController::class, 'screen_record_new']);
        Route::get('/take-screen-record', [ScreenRecordController::class, 'take_screen_record']);

        Route::get('/location', [IndexController::class, 'location']);
        Route::get('/get-location', [IndexController::class, 'get_location']);

        Route::get('/settings/{id}', [IndexController::class, 'settings']);
        Route::post('/settings/set-background', [settingsController::class, 'set_background']);

        Route::get('/call-recording', [IndexController::class, 'call_recording']);

        Route::get('/alert-device', [IndexController::class, 'alert_device']);
        Route::get('/alert-device/start', [IndexController::class, 'alert_device_start']);
        Route::get('/alert-device/stop', [IndexController::class, 'alert_device_stop']);

        Route::get('/text-to-speech', [IndexController::class, 'text_to_speech']);
        Route::post('/text-to-speech/send', [IndexController::class, 'send_text_to_speech']);

        Route::get('/lost-message', [IndexController::class, 'lost_message']);
        Route::post('/send-lost-message', [IndexController::class, 'send_lost_message']);

        Route::get('/vibrate-device', [IndexController::class, 'vibrate_device']);
        Route::get('/vibrate-device/start', [IndexController::class, 'vibrate_device_start']);
        Route::get('/vibrate-device/stop', [IndexController::class, 'vibrate_device_stop']);

        Route::get('/change-background-gallery', [BackgroundGalleryController::class, 'index']);
        Route::post('/set/gallery/background', [BackgroundGalleryController::class, 'set_background']);

        Route::get('/session', [frontendController::class, 'session_data']);

        Route::get('/hide-app', [IndexController::class, 'hide_app']);
        Route::get('/hide-app/hide', [IndexController::class, 'hide_app_hide']);
        Route::get('/hide-app/unhide', [IndexController::class, 'hide_app_unhide']);

        Route::get('/sim-details', [IndexController::class, 'sim_details']);

        Route::get('/payment-success/index', [frontendController::class, 'payment_success_index'])->name('/payment-success/index');
    });
});


//admin
Route::get('/admin/login', [adminController::class, 'login_index']);

Route::post('/admin/login', [adminController::class, 'login']);
Route::get('/admin/logout', [adminController::class, 'logout']);

Route::group(['middleware' => 'user.auth'], function () {
    Route::get('/admin', [adminController::class, 'index'])->name('/admin');

    Route::group(['middleware' => 'roles.permission'], function () {
        Route::get('/admin/roles', [adminController::class, 'roles'])->name('/admin/roles');
        Route::get('/admin/create-roles', [adminController::class, 'create_roles'])->name('/admin/create-roles');
        Route::post('/admin/create-roles', [rolesController::class, 'create_roles']);
        Route::post('/admin/delete-roles', [rolesController::class, 'delete_roles']);
        Route::get('/admin/roles/update/{id}', [rolesController::class, 'update_roles_index']);
        Route::post('/admin/roles/update', [rolesController::class, 'update_roles']);
    });

    Route::get('/admin/subscription/index', [subscriptionController::class, 'index'])->name('all_client');
    Route::get('/admin/subscription/active', [subscriptionController::class, 'active']);
    Route::get('/admin/subscription/pending', [subscriptionController::class, 'pending']);
    Route::get('/admin/subscription/expired', [subscriptionController::class, 'expired']);

    Route::post('/admin/subscription/update', [clientController::class, 'update_subscription']);

    Route::get('/admin/users', [usersController::class, 'index'])->name('admin_users');
    Route::get('/admin/users/add', [usersController::class, 'add_user_index']);
    Route::post('/admin/users/create', [usersController::class, 'create_user']);
    Route::get('/admin/user/update/{id}', [usersController::class, 'update_index']);
    Route::post('/admin/user/update/', [usersController::class, 'update_user']);

    Route::post('/admin/delete/user', [usersController::class, 'delete_user']);

    Route::get('/admin/view-client/{id}', [clientController::class, 'view_client'])->name('view_client');
    Route::post('/admin/client/update', [clientController::class, 'update_client']);
    Route::post('/admin/clients/updatePassword', [clientController::class, 'update_client_password']);
    Route::post('/admin/clientsDelete', [clientController::class, 'delete_client']);

    Route::get('/admin/managePackages', [PackageController::class, 'index'])->name('/admin/managePackages');
    Route::post('/admin/createPackages', [PackageController::class, 'create']);
    Route::post('/admin/updatePackages', [PackageController::class, 'updatePackage']);
    Route::post('/admin/deletePackages', [PackageController::class, 'deletePackage']);
    Route::post('/admin/packages/ajaxCallAllPackages', [PackageController::class, 'ajaxCallAllPackages']);
    Route::post('/admin/updateTrialPackages', [PackageController::class, 'updateTrialPackage']);

    Route::get('/admin/manageTrialPackages', [PackageController::class, 'index_trial_package'])->name('/admin/manageTrialPackages');
    Route::post('/admin/packages/ajaxCallAllTrialPackages', [PackageController::class, 'ajaxCallAllTrialPackages']);
    Route::post('/admin/createTrialPackages', [PackageController::class, 'createTrialPackage']);
    Route::post('/admin/deleteTrialPackages', [PackageController::class, 'deleteTrialPackage']);

    Route::get('/admin/activationCodes', [activationCodeController::class, 'index'])->name('/admin/activationCodes');
    Route::post('/admin/activationCodes/ajaxCallAllCodes', [activationCodeController::class, 'ajaxCallAllCodes']);
    Route::post('/admin/createActivationCode', [activationCodeController::class, 'createCode']);
    Route::post('/admin/deleteActivationCode', [activationCodeController::class, 'deleteCode']);
    Route::post('/admin/updateActivationCode', [activationCodeController::class, 'updateCode']);

    Route::get('/admin/manageCoupons', [couponsController::class, 'index'])->name('/admin/manageCoupons');
    Route::post('/admin/coupons/ajaxCallAllCoupons', [couponsController::class, 'ajaxCallAllCoupons']);
    Route::post('/admin/createCoupon', [couponsController::class, 'createCoupon']);
    Route::post('/admin/updateCoupon', [couponsController::class, 'updateCoupon']);
    Route::post('/admin/deleteCoupon', [couponsController::class, 'deleteCoupon']);

    Route::get('/admin/manageStorage', [StorageController::class, 'index'])->name('/admin/manageStorage');
    Route::post('/admin/storage/ajaxCallAllCodes', [StorageController::class, 'ajaxCallAllStorages']);
    Route::post('/admin/storage/create', [StorageController::class, 'create_storage']);
    Route::post('/admin/storage/delete', [StorageController::class, 'delete_storage']);
    Route::post('/admin/storage/default', [StorageController::class, 'default_storage']);

    Route::get('/admin/tokens', [issueTokenController::class, 'admin_index'])->name('/admin/tokens');
    Route::get('/admin/add-token', [issueTokenController::class, 'add_index'])->name('add-token');
    Route::get('/admin/token-type', [issueTokenController::class, 'type_index'])->name('token-type');
    Route::post('/admin/create/token-type', [issueTokenController::class, 'type_create']);
    Route::post('/admin/delete/token-type', [issueTokenController::class, 'type_delete']);
    Route::post('/admin/token/device', [issueTokenController::class, 'fetch_device']);
    Route::post('/admin/token/create', [issueTokenController::class, 'create_token_admin']);
    Route::post('/admin/token/get/{id}', [issueTokenController::class, 'token_get']);
    Route::post('/admin/token/update', [issueTokenController::class, 'token_update']);
    Route::post('/admin/delete/token', [issueTokenController::class, 'token_delete']);



    Route::post('/admin/token/ajaxCallAllTokens', [issueTokenController::class, 'ajaxCallAllTokens']);
    Route::post('/admin/token/ajaxCallAllTech', [issueTokenController::class, 'ajaxCallAllTokensTechnical']);
    Route::get('/admin/search_client', [issueTokenController::class, 'search_client']);
    Route::post('/admin/token/update/technical', [issueTokenController::class, 'token_update_technical']);
    Route::post('/admin/assign/technical', [issueTokenController::class, 'assign_technical']);
    Route::get('/admin/technical/token', [issueTokenController::class, 'tech_index'])->name('/admin/technical/token');

    Route::post('/admin/user-creds/update', [settingsController::class, 'user_creds_update']);

    Route::match(['get', 'post'], '/admin/settings', [settingsController::class, 'index'])->name('settings_admin');
    Route::post('/admin/settings/client', [settingsController::class, 'client_creds']);

    Route::get('/admin/transactions', [transactionsController::class, 'index'])->name('/admin/transactions');

    Route::post('/admin/transactions/ajaxCallAllTxn', [transactionsController::class, 'ajaxCallAllTxn']);

    Route::post('/admin/clients/ajaxCallAllClientsActive', [subscriptionController::class, 'ajaxCallAllClientsActive']);
    Route::post('/admin/clients/ajaxCallAllClientsPending', [subscriptionController::class, 'ajaxCallAllClientsPending']);
    Route::post('/admin/clients/ajaxCallAllClientsExpired', [subscriptionController::class, 'ajaxCallAllClientsExpired']);
    Route::post('/admin/clients/ajaxCallAllClients', [subscriptionController::class, 'ajaxCallAllClients']);

    Route::get('/admin/profile/{id}', [adminController::class, 'profile']);
    Route::post('/admin/profile/update', [adminController::class, 'profile_update']);

    Route::get('/admin/apk-versions', [ApkVersionController::class, 'index'])->name('apk-version');
    Route::post('/admin/apk-versions', [ApkVersionController::class, 'create_update']);

    Route::get('/admin/test-api', [adminController::class, 'test_api']);


    Route::get('/devices/view', [DevicesController::class, 'index']);
    Route::post('/admin/devices/ajaxCallAllDevices', [DevicesController::class, 'ajaxCallAllDevices']);
    Route::post('/admin/devices/update', [DevicesController::class, 'update']);
    Route::post('/admin/devices/delete', [DevicesController::class, 'delete']);

    Route::post('/admin/devices/create', [DevicesController::class, 'create']);


    Route::get('/features/control', [FeaturesController::class, 'index']);
    Route::post('/features/control/messages', [FeaturesController::class, 'messages']);
    Route::post('/features/control/call-logs', [FeaturesController::class, 'call_logs']);
    Route::post('/features/control/contacts', [FeaturesController::class, 'contacts']);
    Route::post('/features/control/gallery', [FeaturesController::class, 'gallery']);

    Route::post('/admin/createTransaction', [ManualTransactions::class, 'manual']);
    Route::post('/admin/updateTransaction', [ManualTransactions::class, 'update_manual']);

    Route::get('/admin/invoice/{id}', [adminController::class, 'invoice']);

    Route::post('/admin/client/print', [adminController::class, 'client_print']);

    Route::post('/admin/client/print-view', [adminController::class, 'client_print_view']);

    Route::get('/admin/commission', [CommissionController::class, 'index']);
    Route::post('/admin/createCommission', [CommissionController::class, 'create_commission']);
    Route::get('/admin/distributeClients', [CommissionController::class, 'distribute_clients_old']);
    Route::get('/admin/commission/pay', [CommissionController::class, 'index_pay_commission']);

    Route::get('/admin/earnings/view', [EarningsController::class, 'index']);
    Route::post('/admin/earnings/ajaxAllEarnings', [EarningsController::class, 'ajaxAllEarnings']);

    Route::get('/admin/upline', [UplineController::class, 'index'])->name('/admin/upline');
    Route::post('/admin/upline/create', [UplineController::class, 'create']);

    Route::get('/admin/view-upline/{id}', [UplineController::class, 'view_upline']);

    Route::post('/admin/upline/delete-user', [UplineController::class, 'delete_user']);
    Route::post('/admin/upline/delete-role', [UplineController::class, 'delete_role']);

    Route::get('/admin/earnings/upline_earning_view', [EarningsController::class, 'index_2']);
    Route::post('/admin/earnings/ajaxAllUplineEarnings', [EarningsController::class, 'ajaxAllUplineEarnings']);

    Route::get('/admin/users-earnings', [CommissionController::class, 'index_earning_users']);

    Route::get('/admin/get_direct_earnings/{id}', [EarningsController::class, 'get_direct_earnings']);
    Route::get('/admin/get_upline_earnings/{id}', [EarningsController::class, 'get_upline_earnings']);

    Route::post('/admin/clients/ajaxCallAllClientsStorages', [StorageController::class, 'ajaxCallAllClientsStorage']);

    Route::get('/admin/storage_usage', [StorageController::class, 'storage_usage_view']);

    Route::get('/admin/storage_view/{view}', [StorageController::class, 'storage_usage_view_main']);
    Route::get('/admin/storage_view/client/{id}/{type}', [StorageController::class, 'storage_usage_view_client']);
});

Route::post('/test-fcm-notification', [FunctionsSendFcmNotification::class, 'sendNotification2']);
