<?php

namespace App\Actions;

use App\Services\WeatherAPI\WeatherBitAPI\WeatherAlertSpecification\WeatherSpecificationService;
use Illuminate\Support\Collection;

final class CreateWeatherAlertAction
{
    public function __construct(
        private WeatherSpecificationService $weatherSpecificationService,
        private CreateWeatherAlert $createWeatherAlert,
    ) {
    }

    public function __invoke(array $weatherData, Collection $users): void
    {
        $matchingSpecifications = $this->weatherSpecificationService->getMatchingSpecifications($weatherData);
        $alertsToInsert = [];

        foreach ($matchingSpecifications as $specification) {
            foreach ($users as $user) {
                $alertsToInsert[] = [
                    'user_id' => $user->user_id,
                    'alert_type' => $specification['alert_type'],
                    'alert_data' => json_encode($specification['alert_data']),
                    //TODO null value isn't working for insertOrIgnore,
                    // consider changing the value as it's not a valid timestamp in strict SQL modes.
                    'notified_at' => now()->setTimestamp(0)->toDateTimeString(),
                    'notified' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        ($this->createWeatherAlert)($alertsToInsert);
    }
}
