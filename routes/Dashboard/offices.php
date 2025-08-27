<?php

use App\Http\Controllers\Dashboard\OfficesController;
use Illuminate\Support\Facades\Route;

Route::apiResource('offices', OfficesController::class);
