<?php

use Illuminate\Support\Facades\Route;
use App\http\Controllers\Auth\AuthController;

Route::controller(AuthController::class)->group(function() {
    Route::post('register/general-user', 'register_general_user');
    Route::post('register/office', 'register_office');
    Route::post('login', 'login');
    Route::post('verify-account', 'verify_account');
    Route::post('verify-2fa', 'verify_2fa');
});
