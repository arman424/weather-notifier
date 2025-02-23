<?php

namespace App\Actions;

use App\Models\WeatherAlert;

final class UpdateWeatherAlertNotifiedAction
{
    public function __invoke(array $alertIds): void
    {
        WeatherAlert::whereIn('id', $alertIds)
            ->update([
                'notified' => true,
                'notified_at' => now(),
            ]);
    }
}
