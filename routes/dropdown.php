<?php

use App\Models\{
    City,
    Region,
};
use Illuminate\Support\Facades\Route;

Route::get('cities', fn() => ['data' => City::all()]);
Route::get('regions', fn() => ['data' => request('city_id') ? Region::whereCityId(request('city_id'))->get() : Region::all()]);
