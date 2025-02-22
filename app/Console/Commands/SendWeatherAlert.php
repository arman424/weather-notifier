<?php

namespace App\Console\Commands;

use App\Actions\GetWeatherAlertsActions;
use App\Actions\SendWeatherAlertAction;
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
    public function handle(
        GetWeatherAlertsActions $getWeatherAlertsActions,
        SendWeatherAlertAction $sendWeatherAlertAction,
    ): void
    {
        $sendWeatherAlertAction($getWeatherAlertsActions());
    }
}
