<?php

use App\Http\Controllers\PostsComparisonsController;
use Illuminate\Support\Facades\Route;

Route::apiResource('posts-comparisons', PostsComparisonsController::class)->middleware('user');
Route::delete('delete-all-posts-comparisons', [PostsComparisonsController::class, 'delete_all']);
