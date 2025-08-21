<?php

use App\Http\Controllers\Dashboard\CitiesController;
use Illuminate\Support\Facades\Route;

Route::apiResource('cities', CitiesController::class);
