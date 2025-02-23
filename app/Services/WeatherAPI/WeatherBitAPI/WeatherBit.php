<?php

namespace App\Services\WeatherAPI\WeatherBitAPI;

use App\Contracts\WeatherAPIContract;
use App\DTO\WeatherBitDTO;
use App\Services\WeatherAPI\WeatherAPIService;
use Exception;

class WeatherBit extends WeatherAPIService implements WeatherAPIContract
{
    private const WEATHER_TYPE = 'current';

    public function __construct()
    {
        $this->url = env('WEATHERBIT_API_URL') . self::WEATHER_TYPE . '?key=' . env('WEATHERBIT_KEY');
    }

    /**
     * @throws Exception
     */
    public function getWeather(WeatherBitDTO $weatherBitDTO): array
    {
        $this->url = $this->url . $weatherBitDTO->toQueryParam();

        return $this->makeRequest();
    }
}
