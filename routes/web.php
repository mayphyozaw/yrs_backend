<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\Select2AjaxController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\TicketInspectorController;
use App\Http\Controllers\TopUpHistoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WalletTransactionController;
use Illuminate\Support\Facades\Route;


require __DIR__ . '/auth.php';

Route::middleware('auth:admin_users')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('change-password', [PasswordController::class, 'edit'])->name('change-password.edit');
    Route::put('change-password', [PasswordController::class, 'update'])->name('change-password.update');
});

Route::middleware('auth:admin_users', 'verified')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('admin-user', AdminUserController::class);
    Route::get('admin-user-datable', [AdminUserController::class, 'datatable'])->name('admin-user-datable');

    Route::resource('user', UserController::class);
    Route::get('user-datable', [UserController::class, 'datatable'])->name('user-datable');

    Route::resource('wallet', WalletController::class)->only('index');
    Route::get('wallet-datable', [WalletController::class, 'datatable'])->name('wallet-datable');
    Route::get('wallet-add-amount', [WalletController::class, 'addAmount'])->name('wallet-add-amount');
    Route::post('wallet-add-amount', [WalletController::class, 'addAmountStore'])->name('wallet-add-amount.store');
    Route::get('wallet-reduce-amount', [WalletController::class, 'reduceAmount'])->name('wallet-reduce-amount');
    Route::post('wallet-reduce-amount', [WalletController::class, 'reduceAmountStore'])->name('wallet-reduce-amount.store');

    Route::resource('wallet-transaction', WalletTransactionController::class)->only('index','show');
    Route::get('wallet-transaction-datable', [WalletTransactionController::class, 'datatable'])->name('wallet-transaction-datable');


    Route::resource('top-up-history', TopUpHistoryController::class)->only('index','show');
    Route::get('top-up-history-datable', [TopUpHistoryController::class, 'datatable'])->name('top-up-history-datable');
    Route::post('top-up-history-approve/{id}',[TopUpHistoryController::class,'approve'])->name('top-up-history-approve');
    Route::post('top-up-history-reject/{id}',[TopUpHistoryController::class,'reject'])->name('top-up-history-reject');

    Route::resource('station', StationController::class);
    Route::get('station-datable', [StationController::class, 'datatable'])->name('station-datable');


    Route::resource('route', RouteController::class);
    Route::get('route-datable', [RouteController::class, 'datatable'])->name('route-datable');

    Route::resource('ticket-inspector', TicketInspectorController::class);
    Route::get('ticket-inspector-datable', [TicketInspectorController::class, 'datatable'])->name('ticket-inspector-datable');

    Route::prefix('select2-ajax')->name('select2-ajax.')->group(function () {
        Route::get('wallet',[Select2AjaxController::class,'wallet'])->name('wallet');
        Route::get('station',[Select2AjaxController::class,'station'])->name('station');
    });
});
