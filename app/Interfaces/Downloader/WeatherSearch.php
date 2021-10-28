<?php

namespace App\Interfaces\Downloader;

use App\Exceptions\NotFoundLocation;
use App\Interfaces\Weather;

interface WeatherSearch
{
    /**
     * @param string $city
     * @throws NotFoundLocation
     */
    public function searchWeather(string $city): Weather|null;
}
