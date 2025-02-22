<?php

namespace App\Actions;

use App\Models\WeatherAlert;
use App\Notifications\WeatherNotification;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class SendWeatherAlertAction
{
    public function __invoke(Collection $alerts): void
    {
        foreach ($alerts as $userId => $userAlerts) {
            $user = $userAlerts->first()->user;
            $alertData = $userAlerts->flatMap(fn($alert) => $alert->alert_data)->toArray();

            try {
                $user->notify(new WeatherNotification($alertData));

                WeatherAlert::whereIn('id', $userAlerts->pluck('id'))
                    ->update([
                        'notified' => true,
                        'notified_at' => now(),
                    ]);

            } catch (Exception $e) {
                Log::error("Failed to notify user {$userId}: " . $e->getMessage());
            }
        }
    }
}
