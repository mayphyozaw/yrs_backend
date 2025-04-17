<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketInspectorController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


require __DIR__ . '/auth.php';

Route::middleware('auth:admin_users')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('change-password', [PasswordController::class, 'edit'])->name('change-password.edit');
    Route::put('change-password', [PasswordController::class, 'update'])->name('change-password.update');

});

Route::middleware('auth:admin_users')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    
    Route::resource('admin-user',AdminUserController::class);
    Route::get('admin-user-datable', [AdminUserController::class,'datatable'])->name('admin-user-datable');

    Route::resource('user',UserController::class);
    Route::get('user-datable', [UserController::class,'datatable'])->name('user-datable');

    Route::resource('ticket-inspector',TicketInspectorController::class);
    Route::get('ticket-inspector-datable', [TicketInspectorController::class,'datatable'])->name('ticket-inspector-datable');
});
