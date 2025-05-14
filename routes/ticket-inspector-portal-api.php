<?php

use App\Http\Controllers\Api\TicketInspectorPortal\AuthController ;
use App\Http\Controllers\Api\TicketInspectorPortal\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('login',[AuthController::class,'login']);
Route::post('two-step-verification',[AuthController::class,'twoStepVerification']);
Route::post('resend-otp',[AuthController::class,'resendOTP']);

Route::middleware(['auth:ticket_inspectors_api', 'verified'])->group(function () {
    Route::get('profile', [ProfileController::class, 'profile']);
    Route::post('change-password', [ProfileController::class, 'changePassword']);
    Route::post('logout',[AuthController::class, 'logout']);
});