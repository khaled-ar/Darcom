<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::controller(AuthController::class)->group(function() {
    Route::post('register/general-user', 'register_general_user');
    Route::post('register/office', 'register_office');
    Route::post('login', 'login');
    Route::post('verify-account', 'verify_account');
    Route::post('verify-2fa', 'verify_2fa');
    Route::post('refresh-token', 'refresh_token');
    Route::post('forgot-password', 'forgot_password');
    Route::post('reset-password', 'reset_password');
    Route::post('resend-code', 'resend_code')->middleware('throttle:1,2');
    Route::post('verify-code', 'verify_code');
});
