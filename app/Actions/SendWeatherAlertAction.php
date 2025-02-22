<?php

namespace App\Actions;

use App\Services\WeatherAPI\WeatherNotificationService;
use Illuminate\Support\Collection;

final class SendWeatherAlertAction
{
    public function __construct(
        private WeatherNotificationService $weatherNotificationService,
        private UpdateWeatherAlertAction $updateWeatherAlertAction,
    ) {
    }

    public function __invoke(Collection $alerts): void
    {
        foreach ($alerts as $userAlerts) {
            $user = $userAlerts->first()->user;
            $alertData = $userAlerts->flatMap(fn($alert) => $alert->alert_data)->toArray();

            $this->weatherNotificationService->send($user, $alertData);
            ($this->updateWeatherAlertAction)($userAlerts->pluck('id'));
        }
    }
}
