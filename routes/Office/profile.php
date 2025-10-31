<?php

use App\Http\Controllers\Office\ProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('profile')->controller(ProfileController::class)->group(function() {
    Route::get('', 'get_profile');
    Route::post('update', 'update_profile');
    Route::get('work-times', 'get_work_times');
    Route::post('work-times/{work_time}', 'update_work_times');
    Route::delete('work-times/{work_time}', 'delete_work_times');
    Route::post('work-times', 'add_work_times');

});
