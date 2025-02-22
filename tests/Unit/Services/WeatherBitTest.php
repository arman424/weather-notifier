<?php

namespace Services;

use App\DTO\WeatherBitDTO;
use App\Services\WeatherAPI\WeatherBitAPI\WeatherBit;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class WeatherBitTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function test_it_fetches_weather_data_successfully()
    {
        Http::fake([
            'api.weatherbit.io/*' => Http::response([
                'data' => [
                    ['precip' => 10, 'uv' => 3]
                ]
            ]),
        ]);

        $weatherAPI = new WeatherBit();
        $dto = new WeatherBitDTO();
        $dto->setParam('city', 'Yerevan');

        $result = $weatherAPI->getWeather($dto);

        $this->assertEquals(10, $result['precip']);
        $this->assertEquals(3, $result['uv']);
    }

    public function test_it_handles_failed_weather_request()
    {
        Http::fake([
            'api.weatherbit.io/*' => Http::response([], 500),
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Weather API request failed');

        $weatherAPI = new WeatherBit();
        $dto = new WeatherBitDTO();
        $dto->setParam('city', 'Yerevan');

        $weatherAPI->getWeather($dto);
    }
}
