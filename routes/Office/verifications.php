<?php

use App\Http\Controllers\Office\VerificationsController;
use Illuminate\Support\Facades\Route;

Route::prefix('verifications')->apiResource('verifications', VerificationsController::class);
