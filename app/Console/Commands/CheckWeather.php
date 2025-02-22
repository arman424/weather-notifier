<?php

namespace App\Console\Commands;

use App\Actions\GetWeatherDataAction;
use App\Actions\GetWeatherAlertSpecificationAction;
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
        GetWeatherDataAction $getWeatherDataAction,
        GetWeatherAlertSpecificationAction $getWeatherAlertSpecificationAction,
        CreateWeatherAlertAction $createWeatherAlertAction,
    ): void
    {
        $userLocations = $getUserLocationAction();

        foreach ($userLocations as $city => $users) {
            $weatherData = $getWeatherDataAction($weatherBitDTO->setParam('city', $city));
            $alertsToInsert = $getWeatherAlertSpecificationAction($weatherData, $users);
            $createWeatherAlertAction($alertsToInsert);
        }
    }
}
