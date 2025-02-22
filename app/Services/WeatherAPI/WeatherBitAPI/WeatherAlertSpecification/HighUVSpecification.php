<?php

namespace App\Services\WeatherAPI\WeatherBitAPI\WeatherAlertSpecification;

use App\Contracts\WeatherAlertSpecification;
use App\Enums\WeatherAlertEnum;

class HighUVSpecification implements WeatherAlertSpecification
{
    public function isSatisfiedBy(array $weatherData): bool
    {
        return $weatherData['uv'] > config('weather.max_uv_index');
    }

    public function getAlertType(): string
    {
        return WeatherAlertEnum::HIGH_UV->value;
    }
}
