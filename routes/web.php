<?php

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

    Route::get('/verify-account', function () {
        return view('auth.verify');
    })->name('verification.notice');
});
