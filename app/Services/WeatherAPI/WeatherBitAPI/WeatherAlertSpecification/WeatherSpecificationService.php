<?php

namespace App\Services\WeatherAPI\WeatherBitAPI\WeatherAlertSpecification;

class WeatherSpecificationService
{
    public function getMatchingSpecifications(array $weatherData): array
    {
        $weatherSpecifications = app()->tagged('weather_alert_specifications');
        $matchingSpecifications = [];

        foreach ($weatherSpecifications as $weatherSpecification) {
            if ($weatherSpecification->isSatisfiedBy($weatherData)) {
                $matchingSpecifications[] = [
                    'alert_type' => $weatherSpecification->getAlertType(),
                    'alert_data' => $weatherSpecification->getAlertData($weatherData),
                ];
            }
        }

        return $matchingSpecifications;
    }
}
