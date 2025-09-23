<?php

use App\Http\Controllers\Dashboard\VerificationsController;
use Illuminate\Support\Facades\Route;

Route::prefix('verifications')->apiResource('verifications-requests', VerificationsController::class);
