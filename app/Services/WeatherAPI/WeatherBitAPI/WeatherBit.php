<?php

namespace App\Services\WeatherAPI\WeatherBitAPI;

use App\Contracts\WeatherAPIContract;
use App\DTO\WeatherBitDTO;
use Exception;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class WeatherBit implements WeatherAPIContract
{
    private const WEATHER_TYPE = 'current';

    private string $url;

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

        //TODO different exceptions can be thrown and logs can be stored
        try {
            $response = Http::get($this->url);

            if ($response->failed()) {
                throw new Exception('Weather API request failed: ' . $response->body());
            }

            return $response->json()['data'][0] ?? throw new Exception('Invalid response format');

        } catch (RequestException $e) {
            throw new Exception('HTTP request error: ' . $e->getMessage(), $e->getCode(), $e);
        } catch (Exception $e) {
            throw new Exception('General error: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }
}
