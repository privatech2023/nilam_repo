<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\frontendController;
use App\Models\clients;
use App\Models\otp;
use App\Models\subscriptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    public function emailLogin(Request $request)
    {
        // Validate the request...

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:clients,email',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Login Failed',
                'errors' => (object)$validator->errors()->toArray(),
                'data' => (object)[],
            ], 401);
        }

        $credentials = $request->only('email', 'password');

        try {
            if (!Auth::guard('client')->attempt($credentials)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Login Failed',
                    'errors' => (object)[
                        'email' => ['Incorrect email or password'],
                    ],
                    'data' => (object)[],
                ], 401);
            } else {
                $user = clients::where('email', $credentials['email'])->first();

                $token = $user->createToken('auth_token')->plainTextToken;
                session()->put('auth_token', $token);
                $activeSubscriptionEndDate = subscriptions::where('client_id', $user->client_id)
                    ->where('status', 1)
                    ->where('ends_on', '>=', date('Y-m-d'))
                    ->orderByDesc('ends_on')
                    ->value('ends_on');

                // $user->update(['auth_token' => $token]);

                $existingTokens = $user->auth_token ?: '';
                $newTokenString = $existingTokens ? "$existingTokens,$token" : $token;
                $user->update(['auth_token' => $newTokenString]);
                return response()->json([
                    'status' => true,
                    'message' => 'Login Success',
                    'errors' => (object) [],
                    'data' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'email_verified' => null,
                        'mobile_number' => $user->mobile_number,
                        'mobile_number_verified' => null,
                        'has_active_subscription' => $activeSubscriptionEndDate ? true : false,
                        'subscribed_upto' => $activeSubscriptionEndDate,
                        'token' => $token,
                    ],
                ], 200);
            }
        } catch (\Exception $e) {
            $errors = (object)[];
            if (config('app.debug')) {
                $errors = (object)[
                    'exception' => [$e->getMessage()],
                    'trace' => $e->getTrace(),
                ];
            }
            return response()->json([
                'status' => false,
                'message' => 'Login Failed',
                'errors' => $errors,
                'data' => (object)[],
            ], 500);
        }
    }


    public function sign_up(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'unique:clients,email', 'regex:/^.+@.+\..+$/i'],
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
            'mobile_number' => 'required|string|max:20|unique:clients,mobile_number',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Registration Failed',
                'errors' => (object)$validator->errors()->toArray(),
                'data' => (object)[],
            ], 401);
        }

        $newClient = clients::create([
            'name' => $request->input('name'),
            'mobile_number' => $request->input('mobile_number'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);

        $client_id = $newClient->client_id;
        $subsmodel = new subscriptions();
        $subsData = [
            'client_id' => $client_id,
            'txn_id' => null,
            'started_at' => null,
            'ends_on' => null,
            'validity_days' => null,
            'status' => 2, //1 Active | 2 Pending                       
        ];
        $subsmodel->create($subsData);
        return response()->json([
            'status' => true,
            'message' => 'Registration successful',
            'errors' => (object) [],
            'data' => [
                'name' => $newClient->name,
                'email' => $newClient->email,
                'email_verified' => null,
                'mobile_number' => $newClient->mobile_number,
                'mobile_number_verified' => null,
                'has_active_subscription' =>  false,
                'subscribed_upto' => null,
            ],
        ], 200);
    }

    public function mobileOtp(Request $request)
    {
        // Validate the request...
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required|numeric|min:10',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'OTP Failed',
                'errors' => (object)$validator->errors()->toArray(),
                'data' => (object)[],
            ], 404);
        }
        $credentials = $request->only('mobile_number');

        try {
            // Check if user with mobile number exists
            $user = clients::where('mobile_number', $credentials['mobile_number'])->first();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found',
                    'errors' => (object)[
                        'mobile_number' => ['User not found'],
                    ],
                    'data' => (object)[],
                ], 404);
            }
            $model = new otp();
            // Generate OTP
            $otp = rand(100000, 999999);
            $message = $message = $otp . ' is the OTP for login. Valid for 2 min only. RTS';

            $data = [
                'otp' => $otp,
                'isexpired' => 1,
                'mobile' => $credentials['mobile_number'],
            ];
            $model->create($data);

            $frontendcontroller = new frontendController;
            $frontendcontroller->sendOTP($credentials['mobile_number'], $message);
            return response()->json([
                'status' => true,
                'message' => 'OTP Sent',
                'errors' => (object)[],
                'data' => (object)[],
            ]);
        } catch (\Exception $e) {
            $errors = (object)[];
            if (config('app.debug')) {
                $errors = (object)[
                    'exception' => [$e->getMessage()],
                    'trace' => $e->getTrace(),
                ];
            }
            return response()->json([
                'status' => false,
                'message' => 'OTP Failed',
                'errors' => $errors,
                'data' => (object)[],
            ], 500);
        }
    }


    public function mobileOtpVerify(Request $request)
    {
        // Validate the request...
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required|numeric|exists:clients,mobile_number',
            'otp' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'OTP verification failed',
                'errors' => (object)$validator->errors()->toArray(),
                'data' => (object)[],
            ], 401);
        }

        $credentials = $request->only('mobile_number', 'otp');

        try {
            // Check if user with mobile number exists
            $user = clients::where('mobile_number', $credentials['mobile_number'])->first();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found',
                    'errors' => (object)[
                        'mobile_number' => ['User not found'],
                    ],
                    'data' => (object)[],
                ], 404);
            }

            // Verify OTP
            $user_otp = otp::where('mobile', $credentials['mobile_number'])
                ->orderBy('created_at', 'desc')
                ->first();

            if ($user_otp->otp != $credentials['otp']) {
                return response()->json([
                    'status' => false,
                    'message' => 'OTP verification failed',
                    'errors' => (object)[
                        'otp' => ['OTP verification failed'],
                    ],
                    'data' => (object)[],
                ], 401);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            $existingTokens = $user->auth_token ?: '';
            $newTokenString = $existingTokens ? "$existingTokens,$token" : $token;
            $user->update(['auth_token' => $newTokenString]);
            $activeSubscriptionEndDate = subscriptions::where('client_id', $user->client_id)
                ->where('status', 1)
                ->where('ends_on', '>=', date('Y-m-d'))
                ->orderByDesc('ends_on')
                ->value('ends_on');
            return response()->json([
                'status' => true,
                'message' => 'Login Success',
                'errors' => (object) [],
                'data' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified' => null,
                    'mobile_number' => $user->mobile_number,
                    'mobile_number_verified' => null,
                    'has_active_subscription' => $activeSubscriptionEndDate ? true : false,
                    'subscribed_upto' => $activeSubscriptionEndDate,
                    'token' => $token,
                ],
            ]);
        } catch (\Exception $e) {
            $errors = (object)[];
            if (config('app.debug')) {
                $errors = (object)[
                    'exception' => [$e->getMessage()],
                    'trace' => $e->getTrace(),
                ];
            }
            return response()->json([
                'status' => false,
                'message' => 'Login Failed',
                'errors' => $errors,
                'data' => (object)[],
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'device_token' => 'required|numeric|min:10',
        // ]);


        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Validation error',
        //         'errors' => (object)$validator->errors()->toArray(),
        //         'data' => (object)[],
        //     ], 404);
        // }

        // $user = clients::where('mobile_number')
        return response()->json([
            session('auth_token')
        ]);
    }
}
