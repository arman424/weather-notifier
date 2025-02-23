<?php

namespace Tests\Feature;

use App\Contracts\WeatherAPIContract;
use App\Enums\WeatherAlertEnum;
use App\Models\User;
use App\Models\UserLocation;
use App\Models\WeatherAlert;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class CheckWeatherCommandTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Config::set('weather.max_precipitation', 10);
        Config::set('weather.max_uv_index', 8);
    }

    public function test_creates_weather_alerts_for_users()
    {
        $users = User::factory()->count(2)->create();

        foreach ($users as $user) {
            UserLocation::factory()->create([
                'user_id' => $user->id,
                'city' => 'Yerevan',
            ]);
        }

        $this->mock(WeatherAPIContract::class, function ($mock) {
            $mock->shouldReceive('getWeather')
                ->once()
                ->andReturn([
                    'precip' => 11,
                    'uv' => 11,
                ]);
        });

        Artisan::call('app:check-weather');

        $this->assertDatabaseCount('weather_alerts', 4);
        $this->assertDatabaseHas('weather_alerts', ['alert_type' => 'high_uv']);
        $this->assertDatabaseHas('weather_alerts', ['alert_type' => 'high_precipitation']);
    }

    public function test_creates_only_weather_precip_alert_for_users()
    {
        $users = User::factory()->count(2)->create();

        foreach ($users as $user) {
            UserLocation::factory()->create([
                'user_id' => $user->id,
                'city' => 'Yerevan',
            ]);
        }

        $this->mock(WeatherAPIContract::class, function ($mock) {
            $mock->shouldReceive('getWeather')
                ->once()
                ->andReturn([
                    'precip' => 11,
                    'uv' => 5,
                ]);
        });

        Artisan::call('app:check-weather');

        $this->assertDatabaseCount('weather_alerts', 2);
        $this->assertDatabaseMissing('weather_alerts', ['alert_type' => 'high_uv']);
        $this->assertDatabaseHas('weather_alerts', ['alert_type' => 'high_precipitation']);
    }

    public function test_creates_only_weather_uv_index_alert_for_users()
    {
        $users = User::factory()->count(2)->create();

        foreach ($users as $user) {
            UserLocation::factory()->create([
                'user_id' => $user->id,
                'city' => 'Yerevan',
            ]);
        }

        $this->mock(WeatherAPIContract::class, function ($mock) {
            $mock->shouldReceive('getWeather')
                ->once()
                ->andReturn([
                    'precip' => 5,
                    'uv' => 11,
                ]);
        });

        Artisan::call('app:check-weather');

        $this->assertDatabaseCount('weather_alerts', 2);
        $this->assertDatabaseHas('weather_alerts', ['alert_type' => 'high_uv']);
        $this->assertDatabaseMissing('weather_alerts', ['alert_type' => 'high_precipitation']);
    }

    public function test_create_weather_alert_for_notified_users()
    {
        $alertData = [
            'precip' => 11,
            'uv' => 11,
        ];

        $user = User::factory()->create();

        WeatherAlert::factory()->create([
            'user_id' => $user->id,
            'alert_type' => WeatherAlertEnum::HIGH_UV->value,
            'alert_data' => json_encode($alertData),
            'notified_at' => now(),
            'notified' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        UserLocation::factory()->create([
            'user_id' => $user->id,
            'city' => 'Yerevan',
        ]);

        $this->mock(WeatherAPIContract::class, function ($mock) use ($alertData) {
            $mock->shouldReceive('getWeather')
                ->once()
                ->andReturn($alertData);
        });

        Artisan::call('app:check-weather');

        $this->assertDatabaseCount('weather_alerts', 3);
    }
}
