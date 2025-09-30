<?php

use App\Http\Controllers\AdsController;
use App\Http\Controllers\BlogsController;
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

    Route::middleware(['auth:sanctum', 'whatsapp_verified'])->group(function() {

        // Profile Routes
        Route::prefix('profile')->group(function() {
            include base_path('routes/profile.php');
        });

        // Blogs Routes
        Route::apiResource('blogs', BlogsController::class);

        // Ads Routes
        Route::apiResource('ads', AdsController::class);

        // Office Routes
        Route::prefix('office')->group(function() {
            include base_path('routes/Office/profile.php');
            include base_path('routes/Office/employees.php');
            include base_path('routes/Office/verifications.php');
        });
    });


    // Dashboard Routes
    Route::prefix('dashboard')->middleware(['auth:sanctum', 'admin'])->group(function() {

        // Cities Routes
        include base_path('routes/Dashboard/cities.php');
        // Regions Routes
        include base_path('routes/Dashboard/regions.php');
        // General Users Routes
        include base_path('routes/Dashboard/general.users.php');
        // Offices Routes
        include base_path('routes/Dashboard/offices.php');
        // Verifications Routes
        include base_path('routes/Dashboard/verifications.php');
        // Verifications Routes
        include base_path('routes/Dashboard/reasons.php');
    });
});
