<?php

namespace App\Interfaces;

interface WeatherSearch
{
    /**
     * @param string $city
     */
    public function searchWeather(string $city): void;
}
