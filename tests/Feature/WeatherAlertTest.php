<?php

use App\Models\User;
use App\Models\WeatherAlert;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WeatherAlertTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_inserts_new_weather_alerts_without_duplicates()
    {
        $user = User::factory()->create();

        $alertData = [
            'user_id' => $user->id,
            'alert_type' => 'high_uv',
            'alert_data' => json_encode(['uv' => 1]),
            'notified' => false,
            'notified_at' => now(),
        ];

        WeatherAlert::insertOrIgnore($alertData);
        WeatherAlert::insertOrIgnore($alertData);

        $this->assertEquals(1, WeatherAlert::count());
    }
}
