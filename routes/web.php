<?php

use App\Http\Controllers\CustomVerificationController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::middleware('auth')->group(function () {
    Route::middleware('user.status')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });
    Route::get('verify', [CustomVerificationController::class, 'index'])->name('email.verify');
    Route::post('verify', [CustomVerificationController::class, 'resendVerification'])->name('verification.resend');
});
