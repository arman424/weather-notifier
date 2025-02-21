<?php

namespace App\Console\Commands;

use App\Actions\SendWeatherAlertAction;
use App\Models\WeatherAlert;
use App\Notifications\WeatherNotification;
use Illuminate\Console\Command;

class SendWeatherAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-weather-alert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(SendWeatherAlertAction $sendWeatherAlertAction): void
    {
        $sendWeatherAlertAction();
    }
}
