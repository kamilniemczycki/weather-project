<?php

namespace App\Models\Downloader;

use App\Interfaces\Downloader\WeatherDownloader as InterfacesWeatherDownloader;
use Illuminate\Support\Facades\Http;

final class WeatherDownloader extends WeatherParser implements InterfacesWeatherDownloader
{
    private const URL = 'https://wttr.in/{slug}?format=j1';
    private ?int $statusCode = null;

    public function searchWeather(string $city): void
    {
        $response = Http::get(str_replace('{slug}', $city, self::URL));
        $this->statusCode = $response->status();
        $this->setWeather(array_merge($response->json() ?? [], ['city' => $city]));
    }

    public function statusCode(): int
    {
        return $this->statusCode;
    }
}
