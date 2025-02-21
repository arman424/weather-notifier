<?php

namespace App\Services\WeatherAPI;

use Illuminate\Support\Facades\Http;

class WeatherBit
{
    protected $result;

    public function getWeather()
    {
        $url = env('WEATHERBIT_API_URL') . 'current?lat=' .
            40.179188 . "&lon=" .
            44.499104 . "&key=" .
            env('WEATHERBIT_KEY') . "&include=minutely";

        try {
            $this->result = Http::get($url);
            return $this->result->json();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
