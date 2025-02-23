<?php

namespace App\Console\Commands;

use App\Actions\GetWeatherAlertPerUserAction;
use App\Actions\SendWeatherAlertAction;
use App\Actions\UpdateWeatherAlertNotifiedAction;
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
        GetWeatherAlertPerUserAction $getWeatherAlertPerUserAction,
        SendWeatherAlertAction $sendWeatherAlertAction,
    ): void
    {
        $alerts = $getWeatherAlertPerUserAction();

        foreach ($alerts as $userAlerts) {
            $user = $userAlerts->first()->user;
            $sendWeatherAlertAction($user, $userAlerts);
        }
    }
}
