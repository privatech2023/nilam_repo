<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\frontendController;
use App\Models\clients;
use App\Models\otp;
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
            }

            $user = auth('client')->user();

            $token = "2378624828372238";

            return response()->json([
                'status' => true,
                'message' => 'Login Success',
                'errors' => (object)[],
                'data' => (object)[
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified' => null,
                    'mobile_number' => $user->mobile_number,
                    'mobile_number_verified' => null,
                    'has_active_subscription' => null,
                    'subscribed_upto' => null,
                    'purchase_url' => 'in-app-purchase-url',
                    'device_id' => 0001,
                    'device_token' => 00012,
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
            $message = $message = $otp . ' is the OTP to login at RTS. Valid for 1 min only. RTS LLP';

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

            // if (!$otp_verified) {
            //     return response()->json([
            //         'status' => false,
            //         'message' => 'OTP verification failed',
            //         'errors' => (object)[
            //             'otp' => ['OTP verification failed'],
            //         ],
            //         'data' => (object)[],
            //     ], 401);
            // }

            $token = "137982379823412";

            return response()->json([
                'status' => true,
                'message' => 'Login Success',
                'errors' => (object)[],
                'data' => (object)[
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified' => null,
                    'mobile_number' => $user->mobile_number,
                    'mobile_number_verified' => null,
                    'has_active_subscription' => null,
                    'subscribed_upto' => null,
                    'purchase_url' => 'in-app-purchase-url',
                    'device_id' => 0002,
                    'device_token' => 00023,
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
}
