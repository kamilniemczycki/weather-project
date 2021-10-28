<?php

declare(strict_types=1);

namespace App\Models\Downloader;

use App\Interfaces\Downloader\WeatherParser as InterfaceWeatherParser;
use App\Models\Weather;

abstract class WeatherParser implements InterfaceWeatherParser
{
    private ?Weather $weather = null;

    public function getWeather(): Weather|null {
        return $this->weather;
    }

    protected function setWeather(array $response): void
    {
        if ($this->statusCode() === 200 && count($response) > 1) {
            $weather = new Weather(...[
                'city' => $this->unSlugCity($response['city']),
                'country' => $response['nearest_area'][0]['country'][0]['value'],
                'weatherDesc' => $response['current_condition'][0]['weatherDesc'][0]['value'],
                'tempC' => $response['current_condition'][0]['temp_C'],
                'tempF' => $response['current_condition'][0]['temp_F'],
            ]);

            $this->weather = $weather;
        } else {
            $weather = new Weather('Not found');
            $this->weather = $weather;
        }
    }

    abstract public function statusCode(): int;

    private function unSlugCity(string $slugCity): string
    {
        $parsed = '';
        foreach (explode('-', $slugCity) as $word)
            $parsed .= ucfirst($word) . ' ';

        return rtrim($parsed, " ");
    }
}
