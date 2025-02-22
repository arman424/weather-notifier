<?php

namespace App\Services\WeatherAPI\WeatherBitAPI\WeatherAlertSpecification;

use App\Contracts\WeatherAlertSpecification;
use App\Enums\WeatherAlertEnum;

class HighPrecipitationSpecification implements WeatherAlertSpecification
{
    public function isSatisfiedBy(array $weatherData): bool
    {
        return $weatherData['precip'] > config('weather.max_precipitation');
    }

    public function getAlertType(): string
    {
        return WeatherAlertEnum::HIGH_PRECIPITATION->value;
    }

    public function getAlertData(array $weatherData): array
    {
        return ['precip' => $weatherData['precip'] ?? null];
    }
}
