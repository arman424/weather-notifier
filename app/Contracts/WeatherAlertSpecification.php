<?php

namespace App\Services\WeatherAPI\WeatherBitAPI;

interface WeatherAlertSpecification
{
    public function isSatisfiedBy(array $weatherData): bool;

    public function getAlertType(): string;
}
