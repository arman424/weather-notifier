<?php

namespace App\Actions;

use App\Contracts\WeatherAPIContract;
use App\DTO\WeatherBitDTO;

class CheckWeatherAction
{
    public function __construct(
        private WeatherAPIContract $weatherAPI,
    ) {
    }

    public function __invoke(WeatherBitDTO $weatherBitDTO)
    {
        //TODO more weather APIs can be used in the future
        return $this->weatherAPI->getWeather($weatherBitDTO);
    }
}
