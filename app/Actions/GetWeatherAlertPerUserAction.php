<?php

namespace App\Actions;

use App\Models\WeatherAlert;
use Illuminate\Support\Collection;

final class GetWeatherAlertPerUserAction
{
    public function __invoke(): Collection
    {
        return WeatherAlert::where('notified', false)
            ->with('user:id,email')
            ->get(['id', 'user_id', 'alert_data'])
            ->groupBy('user_id');
    }
}
