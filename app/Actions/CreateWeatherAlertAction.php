<?php

namespace App\Actions;

use App\Models\WeatherAlert;
use Illuminate\Support\Collection;

class CreateWeatherAlertAction
{
    public function __invoke(array $weatherData, Collection $users): void
    {
        $weatherSpecifications = app()->tagged('weather_alert_specifications');

        foreach ($weatherSpecifications as $weatherSpecification) {
            if ($weatherSpecification->isSatisfiedBy($weatherData)) {

                $users->map(fn($user) => WeatherAlert::create([
                    'user_id' => $user->user_id,
                    'alert_type' => $weatherSpecification->getAlertType(),
                    'alert_data' => [
                        'precip' => $weatherData['precip'],
                        'uv_index' => $weatherData['uv']
                    ],
                    'notified_at' => null
                ]));
            }
        }
    }
}
