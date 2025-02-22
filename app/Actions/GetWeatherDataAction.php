<?php

namespace App\Actions;

use App\Contracts\WeatherAPIContract;
use App\DTO\WeatherBitDTO;

final class GetWeatherDataAction
{
    public function __construct(
        private WeatherAPIContract $weatherAPI,
    ) {
    }

    public function __invoke(WeatherBitDTO $weatherBitDTO): array
    {
        //TODO more weather APIs can be used in the future
        return $this->weatherAPI->getWeather($weatherBitDTO);
    }
}
