<?php

use App\Http\Controllers\Dashboard\RegionsController;
use Illuminate\Support\Facades\Route;

Route::apiResource('regions', RegionsController::class);
