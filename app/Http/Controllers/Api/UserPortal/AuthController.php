<?php

namespace App\Http\Controllers\Api\UserPortal;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\OTPRepository;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:500',
            'email' => 'required|unique:users,email',
            'password' => 'required|string|min:8|max:20',
        ]);

        DB::beginTransaction();
        try {
            $user = (new UserRepository)->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            (new WalletRepository)->firstOrCreate(
                [
                    'user_id' => $user->id
                ],
                [
                    'amount' => 0
                ]
            );


            if ($user->email_verified_at) {
                    $response = [
                        'is_verified' => 1,
                        'access_token' => $user->createToken(config('app.name'))->plainTextToken
                    ];
                    
                }else{
                    $otp = (new OTPRepository())->send($request->email);
                    $response = [
                        'is_verified' => 0,
                        'otp_token' => $otp->token,
                    ];
                }
            DB::commit();
            return ResponseService::success($response,'Successfully registered');
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseService::fail($e->getMessage());
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'=> 'required|email',
            'password'=> 'required'
        ]);

        DB::beginTransaction();
        try {
            if(Auth::guard('users')->attempt(['email'=>$request->email, 'password'=>$request->password])) // laravel method using
            {
                $user = Auth::guard('users')->user();
                
                if ($user->email_verified_at) {
                    $response = [
                        'is_verified' => 1,
                        'access_token' => $user->createToken(config('app.name'))->plainTextToken
                    ];
                    
                }else{
                    $otp = (new OTPRepository())->send($request->email);
                    $response = [
                        'is_verified' => 0,
                        'otp_token' => $otp->token,
                    ];
                }
                
            }else {
            
                throw new Exception('These credentials do not match our records');
            }
            DB::commit();
            return ResponseService::success($response,'Successfully Logged in');
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseService::fail($e->getMessage());
        }
    }

    public function twoStepVerification(Request $request)
    {
        $request->validate([
            'otp_token' => 'required|string',
            'code' => 'required|string'
        ]);


        DB::beginTransaction();
        try {
            (new OTPRepository())->verify($request->otp_token, $request->code);

            $decrypted_otp_token = decrypt($request->otp_token);
            $user = (new UserRepository())->findByEmail($decrypted_otp_token['email']);

            if(!$user){
                throw new Exception('The user is not found');
            }

            $user = (new UserRepository())->update($user->id, [
                'email_verified_at' => date('Y-m-d H:i:s'),
            ]);

            DB::commit();
            return ResponseService::success([
                'access_token' => $user->createToken(config('app.name'))->plainTextToken
            ],'Successfully Logged in');
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseService::fail($e->getMessage());
        }
    }

    public function resendOTP(Request $request)
    {
        $request->validate([
            'otp_token' => 'required|string',
        ]);
        DB::beginTransaction();
        try {
            $otp = (new OTPRepository())->resend($request->otp_token);
            

            DB::commit();
            return ResponseService::success([
                'otp_token' => $otp->token
            ], 'Successfully resent.');
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseService::fail($e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return ResponseService::success([],'Successfully Logged out');

        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }
}
