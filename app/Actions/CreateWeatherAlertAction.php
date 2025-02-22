<?php

namespace App\Actions;

use App\Models\WeatherAlert;

final class CreateWeatherAlertAction
{
    public function __invoke(array $alertsToInsert): void
    {
        WeatherAlert::insertOrIgnore($alertsToInsert);
    }
}
