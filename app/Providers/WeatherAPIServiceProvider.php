<?php

namespace App\Providers;

use App\Interfaces\Downloader\WeatherDownloader;
use Illuminate\Support\ServiceProvider;

class WeatherAPIServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(WeatherDownloader::class, fn() => new \App\src\Downloader\WeatherDownloader());
    }
}
