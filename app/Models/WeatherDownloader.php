<?php

namespace App\Models;

use App\Interfaces\WeatherSearch;
use App\Models\Downloader\WeatherParser;
use Illuminate\Support\Facades\Http;

final class WeatherDownloader extends WeatherParser implements WeatherSearch
{
    private const URL = 'https://wttr.in/{slug}?format=j1';
    private ?int $statusCode = null;

    public function searchWeather(string $city): void
    {
        $response = Http::get(str_replace('{slug}', $city, self::URL));
        $this->statusCode = $response->status();
        $this->setWeather(array_merge($response->json(), ['city' => $city]));
    }

    public function statusCode(): int
    {
        return $this->statusCode;
    }
}
