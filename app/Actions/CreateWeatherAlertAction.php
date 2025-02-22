<?php

namespace App\Actions;

use App\Models\WeatherAlert;
use Illuminate\Support\Collection;

class CreateWeatherAlertAction
{
    public function __invoke(array $weatherData, Collection $users): void
    {
        $weatherSpecifications = app()->tagged('weather_alert_specifications');
        $alertsToInsert = [];

        foreach ($weatherSpecifications as $weatherSpecification) {
            if (!$weatherSpecification->isSatisfiedBy($weatherData)) {
                continue;
            }

            $alertType = $weatherSpecification->getAlertType();
            $alertData = $weatherSpecification->getAlertData($weatherData);

            foreach ($users as $user) {
                $alertsToInsert[] = [
                    'user_id' => $user->user_id,
                    'alert_type' => $alertType,
                    'alert_data' => $alertData,
                    'notified_at' => null,
                ];
            }
        }

        if (!empty($alertsToInsert)) {
            WeatherAlert::insertOrIgnore($alertsToInsert);
        }
    }
}
