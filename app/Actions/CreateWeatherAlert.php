<?php

namespace App\Actions;

use App\Models\WeatherAlert;

final class CreateWeatherAlert
{
    public function __invoke(array $alertsToInsert): void
    {
        if (!empty($alertsToInsert)) {
            WeatherAlert::insertOrIgnore($alertsToInsert);
        }
    }
}
