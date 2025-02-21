<?php

namespace App\Services\WeatherAPI;

use App\DTO\WeatherBitDTO;

interface WeatherAPIContract
{
    public function getWeather(WeatherBitDTO $weatherBitDTO);
}
