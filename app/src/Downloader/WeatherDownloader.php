<?php

declare(strict_types=1);

namespace App\src\Downloader;

use App\Exceptions\NotFoundLocation;
use App\Interfaces\Downloader\WeatherDownloader as InterfacesWeatherDownloader;
use App\Interfaces\Weather;
use Illuminate\Support\Facades\Http;

final class WeatherDownloader extends WeatherParser implements InterfacesWeatherDownloader
{
    private const URL = 'https://wttr.in/{slug}?format=j1';
    private ?int $statusCode = null;

    public function searchWeather(string $city): Weather|null
    {
        $response = Http::get(str_replace('{slug}', $city, self::URL));
        $this->statusCode = $response->status();
        if($this->statusCode() !== 200 || ($responseJson = $response->json()) === null)
            throw new NotFoundLocation('The specified location was not found');

        $this->setWeather(array_merge($responseJson, ['city' => $city]));

        return $this->getWeather();
    }

    public function statusCode(): int
    {
        return $this->statusCode;
    }
}
