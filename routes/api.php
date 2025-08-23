<?php

use Illuminate\Support\Facades\Route;

Route::middleware('lang')->group(function() {

    // DropDown Routes
    include base_path('routes/dropdown.php');

    // Auth Routes
    include base_path('routes/auth.php');

    // Auth Routes
    Route::prefix('auth')->group(function() {
        include base_path('routes/auth.php');
    });

    Route::middleware('auth:sanctum')->group(function() {

        // Profile Routes
        Route::prefix('profile')->group(function() {
            include base_path('routes/profile.php');
        });
    });


    // Dashboard Routes
    Route::prefix('dashboard')->middleware(['auth:sanctum', 'admin'])->group(function() {

        // Cities Routes
        include base_path('routes/Dashboard/cities.php');
        // Regions Routes
        include base_path('routes/Dashboard/regions.php');
    });
});
