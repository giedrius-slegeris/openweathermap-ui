<?php

namespace App\Http\Controllers;

use App\Services\WeatherStoreMapService;
use Exception;
use Illuminate\Contracts\View\View;

class WeatherStoreMapController {

    /**
     * @param WeatherStoreMapService $s
     * @return View
     * @throws Exception
     */
    public function getWeather(
        WeatherStoreMapService $s
    ): View
    {
        return view('weather.index', $s->getWeatherData());
    }
}
