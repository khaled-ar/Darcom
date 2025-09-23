<?php

use App\Http\Controllers\Office\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::prefix('employees')->apiResource('employees', EmployeeController::class);
