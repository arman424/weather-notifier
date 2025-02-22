<?php

namespace Actions;

use App\Actions\GetWeatherDataAction;
use App\Contracts\WeatherAPIContract;
use App\DTO\WeatherBitDTO;
use Tests\TestCase;

class CheckWeatherActionTest extends TestCase
{
    public function test_it_fetches_weather_data_correctly()
    {
        $mockWeatherAPI = $this->createMock(WeatherAPIContract::class);
        $mockWeatherAPI->expects($this->once())
            ->method('getWeather')
            ->willReturn([
                'precip' => 10,
                'uv' => 5,
            ]);

        $action = new GetWeatherDataAction($mockWeatherAPI);
        $dto = new WeatherBitDTO();
        $dto->setParam('city', 'Yerevan');

        $result = $action($dto);

        $this->assertArrayHasKey('precip', $result);
        $this->assertArrayHasKey('uv', $result);
        $this->assertEquals(10, $result['precip']);
        $this->assertEquals(5, $result['uv']);
    }
}
