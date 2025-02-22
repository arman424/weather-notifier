<?php

namespace App\Contracts;

interface WeatherAlertSpecification
{
    public function isSatisfiedBy(array $weatherData): bool;

    public function getAlertType(): string;

    public function getAlertData(array $weatherData): array;
}
