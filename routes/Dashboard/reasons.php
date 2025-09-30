<?php

use App\Http\Controllers\Dashboard\ReasonsController;
use Illuminate\Support\Facades\Route;

Route::apiResource('reasons', ReasonsController::class);
