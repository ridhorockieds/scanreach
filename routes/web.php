<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomVerificationController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::middleware('auth')->group(function () {
    Route::middleware('user.status')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('items', ItemController::class)->parameters([
            'items' => 'item:uuid'
        ]);
        Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
        Route::get('/chat/{id}', [ChatController::class, 'show'])->name('chat.show');
        Route::delete('/chat/{id}', [ChatController::class, 'destroy'])->name('chat.destroy');
        Route::group(['prefix' => 'setting'], function () {
            Route::get('/', [SettingController::class, 'index'])->name('setting.index');
            Route::get('/account', [SettingController::class, 'account'])->name('setting.account');
            Route::get('/notification', [SettingController::class, 'notification'])->name('setting.notification');
            Route::put('/update-profile', [SettingController::class, 'updateProfile'])->name('setting.updateProfile');
        });
    });
    Route::get('verify', [CustomVerificationController::class, 'index'])->name('email.verify');
    Route::post('verify', [CustomVerificationController::class, 'resendVerification'])->name('verification.resend');
});

Route::get('/c/{uuid}', [ChatController::class, 'create'])->name('chat.create');
Route::post('/c/{uuid}', [ChatController::class, 'sendChat'])->name('chat.send');