<?php

namespace App\Interfaces\Downloader;

use App\Interfaces\Weather;

interface WeatherData
{
    public function getWeather(): Weather|null;
}
