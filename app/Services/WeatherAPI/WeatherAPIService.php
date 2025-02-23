<?php

namespace App\Services\WeatherAPI;

use Exception;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

abstract class WeatherAPIService
{
    protected string $url;

    /**
     * @throws Exception
     */
    protected function makeRequest(): array
    {
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
