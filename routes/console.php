<?php

use App\Jobs\CheckWeatherJob;
use App\Jobs\SendWeatherAlertsJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::job(new CheckWeatherJob())->everySecond();
Schedule::job(new SendWeatherAlertsJob())->everySecond();

