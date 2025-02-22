<?php

namespace Services;

use App\Enums\WeatherAlertEnum;
use App\Services\WeatherAPI\WeatherBitAPI\WeatherAlertSpecification\HighPrecipitationSpecification;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class HighPrecipitationSpecificationTest extends TestCase
{
    public function test_it_satisfies_high_precipitation_condition()
    {
        Config::set('weather.max_precipitation', 10);

        $specification = new HighPrecipitationSpecification();

        $weatherData = ['precip' => 15];
        $this->assertTrue($specification->isSatisfiedBy($weatherData));
    }

    public function test_it_does_not_satisfy_high_precipitation_condition()
    {
        Config::set('weather.max_precipitation', 10);

        $specification = new HighPrecipitationSpecification();

        $weatherData = ['precip' => 5];
        $this->assertFalse($specification->isSatisfiedBy($weatherData));
    }

    public function test_it_returns_correct_alert_type()
    {
        $specification = new HighPrecipitationSpecification();
        $this->assertEquals(WeatherAlertEnum::HIGH_PRECIPITATION->value, $specification->getAlertType());
    }

    public function test_it_returns_correct_alert_data()
    {
        $specification = new HighPrecipitationSpecification();

        $weatherData = ['precip' => 20];
        $expectedData = ['precip' => 20];

        $this->assertEquals($expectedData, $specification->getAlertData($weatherData));
    }
}
