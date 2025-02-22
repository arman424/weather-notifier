<?php

namespace App\Actions;

use App\Models\WeatherAlert;
use Illuminate\Support\Collection;

final class UpdateWeatherAlertAction
{
    public function __invoke(Collection $alertIds): void
    {
        WeatherAlert::whereIn('id', $alertIds)
            ->update([
                'notified' => true,
                'notified_at' => now(),
            ]);
    }
}
