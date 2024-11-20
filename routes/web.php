<?php

use App\Http\Controllers\CustomVerificationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::middleware('auth')->group(function () {
    Route::middleware('user.status')->group(function () {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    });
    Route::get('verify', [CustomVerificationController::class, 'index'])->name('email.verify');
    Route::post('verify', [CustomVerificationController::class, 'resendVerification'])->name('verification.resend');
});
