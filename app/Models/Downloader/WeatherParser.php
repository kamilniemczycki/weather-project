<?php

namespace App\Models\Downloader;

use App\Interfaces\StatusCode;
use App\Models\Weather;

abstract class WeatherParser implements StatusCode
{
    private ?Weather $weather = null;

    public function getWeather(): Weather|null {
        return $this->weather;
    }

    protected function setWeather(array $response): void
    {
        if ($this->statusCode() === 200) {
            $weather = new Weather(...[
                'city' => $this->unSlugCity($response['city']),
                'country' => $response['nearest_area'][0]['country'][0]['value'],
                'weatherDesc' => $response['current_condition'][0]['weatherDesc'][0]['value'],
                'tempC' => $response['current_condition'][0]['temp_C'],
                'tempF' => $response['current_condition'][0]['temp_F'],
            ]);

            $this->weather = $weather;
        }
    }

    abstract public function statusCode(): int;

    private function unSlugCity(string $slugCity): string
    {
        $parsed = '';
        $words = explode('-', $slugCity);
        $wordsCount = count($words);
        foreach ($words as $key => $word) {
            $parsed .= ucfirst($word) . ($key !== $wordsCount-1 ? ' ' : '');
        }

        return $parsed;
    }
}
