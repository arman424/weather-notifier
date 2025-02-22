<?php

namespace App\Actions;

use App\Models\WeatherAlert;
use App\Notifications\WeatherNotification;

class SendWeatherAlertAction
{
    public function __invoke()
    {
        $alerts = WeatherAlert::whereNull('notified_at')->get();

        foreach ($alerts as $alert) {
            $alert->user->notify(new WeatherNotification($alert->alert_data));
            $alert->update(['notified_at' => now()]);
        }
    }
}
