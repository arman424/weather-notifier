<?php

namespace Database\Factories;

use App\Enums\WeatherAlertEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WeatherAlert>
 */
class WeatherAlertFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'alert_type' => WeatherAlertEnum::HIGH_UV->value,
            'alert_data' => json_encode(['uv' => $this->faker->numberBetween(8, 12)]),
            'notified' => false,
            'notified_at' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
