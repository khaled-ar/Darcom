<?php

use App\Http\Controllers\Dashboard\OfficesController;
use Illuminate\Support\Facades\Route;

Route::prefix('employees')->controller(OfficesController::class)->group(function() {
    Route::get('', 'get_employees');
});

