<?php

use App\Http\Controllers\SubscriptionsController;
use Illuminate\Support\Facades\Route;

Route::apiResource('dashboard/subscriptions', SubscriptionsController::class)->except('store')->middleware('admin');
Route::post('subscriptions', [SubscriptionsController::class, 'store']);
