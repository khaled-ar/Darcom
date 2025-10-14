<?php

use App\Http\Controllers\FavoritesController;
use Illuminate\Support\Facades\Route;

Route::apiResource('favorites', FavoritesController::class);
