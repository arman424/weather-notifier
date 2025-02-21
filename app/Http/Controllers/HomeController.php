<?php

namespace App\Http\Controllers;

use App\Services\WeatherAPI\WeatherBit;

class HomeController extends Controller
{
    public function __invoke(WeatherBit $weatherBit)
    {
        dd($weatherBit->getWeather());
    }
}
