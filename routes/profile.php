<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::controller(ProfileController::class)->group(function() {
    Route::get('', 'show');
    Route::post('update', 'update');
    Route::post('employee/update-password', 'update_employee');
    Route::delete('delete', 'destroy');
});
