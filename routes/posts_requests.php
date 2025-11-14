<?php

use App\Http\Controllers\PostsRequestsController;
use Illuminate\Support\Facades\Route;

Route::apiResource('posts-requests', PostsRequestsController::class)->middleware('user');
