<?php

use Illuminate\Support\Facades\Route;

Route::middleware('lang')->group(function() {

    // DropDown Routes
    include base_path('routes/dropdown.php');

    // Auth Routes
    include base_path('routes/auth.php');

    // Dashboard Routes
    Route::prefix('dashboard')->middleware(['auth', 'admin'])->group(function() {

        // Cities Routes
        include base_path('routes/Dashboard/cities.php');
        // Regions Routes
        include base_path('routes/Dashboard/regions.php');
    });

    // Auth Routes
    Route::prefix('auth')->group(function() {
        include base_path('routes/auth.php');
    });
});
