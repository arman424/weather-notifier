<?php

namespace App\Actions;

use App\Models\User;
use App\Notifications\WeatherNotification;
use Exception;
use Illuminate\Support\Facades\Log;

final class SendWeatherAlertAction
{
    public function __invoke(User $user, array $alertData): void
    {
        try {
            $user->notify(new WeatherNotification($alertData));
        } catch (Exception $e) {
            //TODO a generic logger service can be created
            Log::error("Failed to notify user {$user->id}: " . $e->getMessage());
        }
    }
}
