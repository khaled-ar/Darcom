<?php

use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;

Route::apiResource('posts', PostsController::class);
