<?php

namespace App\Contracts;

use App\DTO\WeatherBitDTO;

interface WeatherAPIContract
{
    public function getWeather(WeatherBitDTO $weatherBitDTO): array;
}
