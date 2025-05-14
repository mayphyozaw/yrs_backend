<?php

namespace App\Http\Controllers\Api\TicketInspectorPortal;

use App\Http\Controllers\Controller;
use App\Repositories\OTPRepository;
use App\Repositories\TicketInspectorRespository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\ResponseService;
use Exception;



class AuthController extends Controller
{
   
    public function login(Request $request)
    {
        $request->validate([
            'email'=> 'required|email',
            'password'=> 'required'
        ]);

        DB::beginTransaction();
        try {
            if(Auth::guard('ticket_inspectors')->attempt(['email'=>$request->email, 'password'=>$request->password])) // laravel method using
            {
                $user = Auth::guard('ticket_inspectors')->user();
                
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
            $ticket_inspector = (new TicketInspectorRespository())->findByEmail($decrypted_otp_token['email']);

            if(!$ticket_inspector){
                throw new Exception('The ticket inspector is not found');
            }

            $ticket_inspector = (new TicketInspectorRespository())->update($ticket_inspector->id, [
                'email_verified_at' => date('Y-m-d H:i:s'),
            ]);

            DB::commit();
            return ResponseService::success([
                'access_token' => $ticket_inspector->createToken(config('app.name'))->plainTextToken
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
