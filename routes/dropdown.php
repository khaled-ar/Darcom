<?php

use App\Models\{
    City,
    Reason,
    Region,
};
use Illuminate\Support\Facades\Route;

Route::get('cities', fn() => ['data' => City::all()]);
Route::get('regions', fn() => ['data' => request('city_id') ? Region::whereCityId(request('city_id'))->get() : Region::all()]);
Route::get('reasons', fn() => ['reasons' => Reason::all('reason')]);
