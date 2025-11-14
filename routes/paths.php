<?php

use App\Http\Controllers\PathsController;
use Illuminate\Support\Facades\Route;

Route::apiResource('paths', PathsController::class)->middleware('user');
