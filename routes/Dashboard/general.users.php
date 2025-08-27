<?php

use App\Http\Controllers\Dashboard\GeneralUsersController;
use Illuminate\Support\Facades\Route;

Route::apiResource('general-users', GeneralUsersController::class);
