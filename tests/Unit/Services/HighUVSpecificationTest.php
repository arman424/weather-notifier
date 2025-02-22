<?php

namespace Services;

use App\Enums\WeatherAlertEnum;
use App\Services\WeatherAPI\WeatherBitAPI\WeatherAlertSpecification\HighUVSpecification;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class HighUVSpecificationTest extends TestCase
{
    public function test_it_satisfies_high_uv_condition()
    {
        Config::set('weather.max_uv_index', 8);

        $specification = new HighUVSpecification();

        $weatherData = ['uv' => 10];
        $this->assertTrue($specification->isSatisfiedBy($weatherData));
    }

    public function test_it_does_not_satisfy_high_uv_condition()
    {
        Config::set('weather.max_uv_index', 8);

        $specification = new HighUVSpecification();

        $weatherData = ['uv' => 6];
        $this->assertFalse($specification->isSatisfiedBy($weatherData));
    }

    public function test_it_returns_correct_alert_type()
    {
        $specification = new HighUVSpecification();
        $this->assertEquals(WeatherAlertEnum::HIGH_UV->value, $specification->getAlertType());
    }

    public function test_it_returns_correct_alert_data()
    {
        $specification = new HighUVSpecification();

        $weatherData = ['uv' => 9];
        $expectedData = ['uv' => 9];

        $this->assertEquals($expectedData, $specification->getAlertData($weatherData));
    }
}
