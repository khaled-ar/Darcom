<?php

use App\Http\Controllers\AdsController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

Route::middleware('lang')->group(function() {

    // Get Categories
    Route::get('categories', [CategoriesController::class, 'index']);

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

        // Posts Routes
        include base_path('routes/posts.php');

        // Favorites Routes
        include base_path('routes/favorites.php');

        // Blogs Routes
        Route::apiResource('blogs', BlogsController::class);

        // Ads Routes
        Route::apiResource('ads', AdsController::class);

        // Get Category Filters
        Route::get('category-filters', fn() => ['filters' => Category::whereId(request('category_id'))->first()?->filters]);

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
        // Reasons Routes
        include base_path('routes/Dashboard/reasons.php');
        // Categories Routes
        include base_path('routes/Dashboard/categories.php');
        // Extra Filters
        Route::get('extra-filters', fn() => (include base_path('app/Data/filters.php'))['extra']);
    });
});
