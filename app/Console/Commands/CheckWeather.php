<?php

namespace App\Console\Commands;

use App\Actions\CheckWeatherAction;
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
    public function handle(CheckWeatherAction $checkWeatherAction): void
    {
        $checkWeatherAction();
    }
}
