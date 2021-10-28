<?php

namespace App\Interfaces\Downloader;

interface WeatherSearch
{
    /**
     * @param string $city
     */
    public function searchWeather(string $city): void;
}
