<?php

use App\Http\Controllers\WeatherStoreMapController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/weather', [WeatherStoreMapController::class, 'getWeather']);