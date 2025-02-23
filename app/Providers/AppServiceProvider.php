<?php

namespace App\Providers;

use App\Contracts\WeatherAlertSpecification;
use App\Contracts\WeatherAPIContract;
use App\Listeners\UpdateWeatherAlertNotifiedListener;
use App\Services\WeatherAPI\WeatherBitAPI\WeatherAlertSpecification\HighPrecipitationSpecification;
use App\Services\WeatherAPI\WeatherBitAPI\WeatherAlertSpecification\HighUVSpecification;
use App\Services\WeatherAPI\WeatherBitAPI\WeatherBit;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(WeatherAPIContract::class, WeatherBit::class);

        $this->app->bind(WeatherAlertSpecification::class, HighPrecipitationSpecification::class);
        $this->app->bind(WeatherAlertSpecification::class, HighUVSpecification::class);

        $this->app->tag([HighPrecipitationSpecification::class, HighUVSpecification::class], 'weather_alert_specifications');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            NotificationSent::class,
            UpdateWeatherAlertNotifiedListener::class,
        );
    }
}
