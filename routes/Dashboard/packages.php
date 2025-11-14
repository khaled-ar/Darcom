<?php

use App\Http\Controllers\Dashboard\PackagesController;
use Illuminate\Support\Facades\Route;

Route::apiResource('packages', PackagesController::class);
