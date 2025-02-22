<?php

namespace App\Console\Commands;

use App\Actions\CheckWeatherAction;
use App\Actions\CreateWeatherAlertAction;
use App\Actions\GetUserLocationAction;
use App\DTO\WeatherBitDTO;
use Illuminate\Console\Command;

class CheckWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-weather';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(
        GetUserLocationAction $getUserLocationAction,
        WeatherBitDTO $weatherBitDTO,
        CheckWeatherAction $checkWeatherAction,
        CreateWeatherAlertAction $createWeatherAlertAction,
    ): void
    {
        $userLocations = $getUserLocationAction();

        foreach ($userLocations as $city => $users) {
            $weatherData = $checkWeatherAction($weatherBitDTO->setParam('city', $city));
            $createWeatherAlertAction($weatherData, $users);
        }
    }
}
