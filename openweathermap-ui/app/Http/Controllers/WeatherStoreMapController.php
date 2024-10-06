<?php

namespace App\Http\Controllers;

use App\Services\WeatherStoreMapService;
use Illuminate\Http\Response;

class WeatherStoreMapController {

    public function getWeather(
        WeatherStoreMapService $s
    ): Response
    {
        return new Response($s->test());
    }

}