<?php

use App\Http\Controllers\Api\UserPortal\AuthController;
use App\Http\Controllers\Api\UserPortal\ProfileController;
use App\Http\Controllers\Api\UserPortal\TicketController;
use App\Http\Controllers\Api\UserPortal\TopUpController;
use App\Http\Controllers\Api\UserPortal\TopUpHistoryController;
use App\Http\Controllers\Api\UserPortal\WalletTransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::post('two-step-verification',[AuthController::class,'twoStepVerification']);
Route::post('resend-otp',[AuthController::class,'resendOTP']);



Route::middleware(['auth:users_api', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'profile']);
    Route::post('change-password', [ProfileController::class, 'changePassword']);
    Route::post('logout',[AuthController::class, 'logout']);


    //Ticket
    Route::get('ticket',[TicketController::class, 'index']);
    Route::get('ticket/{ticket_number}',[TicketController::class, 'show']);

    //TopUp History
    Route::get('top-up-history',[TopUpHistoryController::class, 'index']);
    Route::get('top-up-history/{trx_id}',[TopUpHistoryController::class, 'show']);

    //Top Up
    Route::post('top-up',[TopUpController::class, 'store']);


    //Wallet Transaction
    Route::get('wallet-transaction',[WalletTransactionController::class, 'index']);
    Route::get('wallet-transaction/{trx_id}',[WalletTransactionController::class, 'show']);
});