<?php

namespace Actions;

use App\Actions\GetWeatherAlertPerUserAction;
use App\Models\User;
use App\Models\WeatherAlert;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetWeatherAlertsActionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_retrieves_weather_alerts_grouped_by_user_id()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        WeatherAlert::factory()->create([
            'user_id' => $user1->id,
            'alert_type' => 'high_uv',
            'alert_data' => ['uv' => 10],
            'notified_at' => now()->setTimestamp(0)->toDateTimeString(),
        ]);

        WeatherAlert::factory()->create([
            'user_id' => $user1->id,
            'alert_type' => 'high_precipitation',
            'alert_data' => ['precip' => 10],
            'notified_at' => now()->setTimestamp(0)->toDateTimeString(),
        ]);

        WeatherAlert::factory()->create([
            'user_id' => $user2->id,
            'alert_type' => 'high_uv',
            'alert_data' => ['uv' => 10],
            'notified_at' => now()->setTimestamp(0)->toDateTimeString(),
        ]);

        $action = new GetWeatherAlertPerUserAction();
        $result = $action();

        $this->assertCount(2, $result);
        $this->assertCount(2, $result[$user1->id]);
        $this->assertCount(1, $result[$user2->id]);

        $this->assertEquals($user1->id, $result[$user1->id]->first()->user_id);
        $this->assertEquals($user2->id, $result[$user2->id]->first()->user_id);
    }
}
