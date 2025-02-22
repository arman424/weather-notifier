<?php

namespace App\Services\WeatherAPI;

use App\Models\User;
use App\Notifications\WeatherNotification;
use Exception;
use Illuminate\Support\Facades\Log;

class WeatherNotificationService
{
    public function send(User $user, array $alertData): void
    {
        try {
            $user->notify(new WeatherNotification($alertData));
        } catch (Exception $e) {
            Log::error("Failed to notify user {$user->id}: " . $e->getMessage());
        }
    }
}
