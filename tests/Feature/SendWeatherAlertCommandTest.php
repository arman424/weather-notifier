<?php

use App\Listeners\UpdateWeatherAlertNotifiedListener;
use App\Models\User;
use App\Models\WeatherAlert;
use App\Notifications\WeatherNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendWeatherAlertCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_sends_weather_alerts_and_updates_database()
    {
        Notification::fake();
        Event::fake();

        $user = User::factory()->create();

        $alert = WeatherAlert::factory()->create([
            'user_id' => $user->id,
            'notified' => false,
            'notified_at' => now()->setTimestamp(0)->toDateTimeString(),
        ]);

        Artisan::call('app:send-weather-alert');

        Notification::assertSentTo($user, WeatherNotification::class, function ($notification, $channels) {
            return in_array('mail', $channels) && in_array('slack', $channels);
        });

        $notification = new WeatherNotification(
            alertData: [$alert->alert_data],
            alertIds: [$alert->id]
        );

        $event = new NotificationSent($user, $notification, 'mail');
        $listener = app(UpdateWeatherAlertNotifiedListener::class);
        $listener->handle($event);

        $this->assertDatabaseHas('weather_alerts', [
            'id' => $alert->id,
            'notified' => true,
        ]);
    }

    public function test_logs_error_if_notification_fails()
    {
        Notification::fake();
        Log::shouldReceive('error')->once();

        $user = User::factory()->create();

        WeatherAlert::factory()->create([
            'user_id' => $user->id,
            'notified' => false,
            'notified_at' => now()->setTimestamp(0)->toDateTimeString(),
        ]);

        Notification::shouldReceive('send')
            ->andThrow(new \Exception('Notification failed'));

        Artisan::call('app:send-weather-alert');
    }
}
