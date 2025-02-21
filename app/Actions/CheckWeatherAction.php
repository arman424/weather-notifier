<?php

namespace App\Actions;

use App\Services\WeatherAPI\WeatherAPIContract;

class CheckWeatherAction
{
    public function __construct(
        private WeatherAPIContract $weatherAPI
    ) {
    }

    public function __invoke()
    {
        //TODO more weather APIs can be used in the future
        $this->weatherAPI->getWeather();
    }
}
