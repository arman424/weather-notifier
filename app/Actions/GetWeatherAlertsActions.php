<?php

namespace App\Actions;

use App\Models\WeatherAlert;
use Illuminate\Support\Collection;

final class GetWeatherAlertsActions
{
    public function __invoke(): Collection
    {
        return WeatherAlert::where('notified', false)
            ->with('user:id,email')
            ->get()
            ->groupBy('user_id');
    }
}
