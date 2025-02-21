<?php

namespace App\Services\WeatherAPI;

use App\DTO\WeatherBitDTO;
use Exception;
use Illuminate\Support\Facades\Http;

class WeatherBit implements WeatherAPIContract
{
    public function getWeather(WeatherBitDTO $weatherBitDTO)
    {
        $url = env('WEATHERBIT_API_URL') . 'current'. $weatherBitDTO->toQueryParam() ."&key=" . env('WEATHERBIT_KEY');

        try {
            return Http::get($url)->json()['data'][0];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
