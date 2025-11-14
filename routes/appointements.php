<?php

use App\Http\Controllers\AppointementsController;
use Illuminate\Support\Facades\Route;

Route::prefix('appointements')->controller(AppointementsController::class)->group(function() {
    Route::post('', 'store');
})->middleware('user');
