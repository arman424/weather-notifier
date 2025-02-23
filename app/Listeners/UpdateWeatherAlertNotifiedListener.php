<?php

namespace App\Listeners;

use App\Actions\UpdateWeatherAlertNotifiedAction;
use App\Notifications\WeatherNotification;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Support\Facades\Log;

class UpdateWeatherAlertNotifiedListener
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private UpdateWeatherAlertNotifiedAction $updateWeatherAlertNotifiedAction
    ) {
    }

    /**
     * Handle the event.
     */
    public function handle(NotificationSent $event): void
    {
        if ($event->notification instanceof WeatherNotification) {
            $alertIds = $event->notification->alertIds;
            ($this->updateWeatherAlertNotifiedAction)($alertIds);
        }
    }
}
