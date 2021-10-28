<?php

declare(strict_types=1);

namespace App\src\Downloader;

use App\Interfaces\Downloader\WeatherParser as InterfaceWeatherParser;
use App\src\Weather;

abstract class WeatherParser implements InterfaceWeatherParser
{
    private ?Weather $weather = null;

    public function getWeather(): Weather|null {
        return $this->weather;
    }

    protected function setWeather(array $response): void
    {
        $weather = new Weather(...[
            'city' => $this->unSlugCity($response['city']),
            'country' => $response['nearest_area'][0]['country'][0]['value'],
            'weatherDesc' => $response['current_condition'][0]['weatherDesc'][0]['value'],
            'tempC' => $response['current_condition'][0]['temp_C'],
            'tempF' => $response['current_condition'][0]['temp_F'],
        ]);

        $this->weather = $weather;
    }

    abstract public function statusCode(): int;

    public function unSlugCity(string $slugCity): string
    {
        $parsed = '';
        foreach (explode('-', $slugCity) as $word)
            $parsed .= ucfirst($word) . ' ';

        return rtrim($parsed, " ");
    }
}
