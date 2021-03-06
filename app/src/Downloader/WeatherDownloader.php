<?php

declare(strict_types=1);

namespace App\src\Downloader;

use App\Exceptions\NotFoundLocation;
use App\Interfaces\Downloader\WeatherDownloader as InterfacesWeatherDownloader;
use App\Interfaces\Weather;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class WeatherDownloader extends WeatherParser implements InterfacesWeatherDownloader
{
    protected const URL = 'https://wttr.in/{slug}?format=j1';
    protected ?int $statusCode = null;

    /**
     * @param string $city
     * @return Weather|null
     * @throws NotFoundLocation
     */
    public function searchWeather(string $city): Weather|null
    {
        $response = $this->downloadWithAPI($city);
        if(
            $this->statusCode() !== 200 ||
            ($responseJson = $response->json()) === null ||
            $responseJson === []
        ) throw new NotFoundLocation('The specified location was not found');

        $this->setWeather(array_merge($responseJson, ['city' => $city]));

        return $this->getWeather();
    }

    public function statusCode(): int
    {
        return $this->statusCode;
    }

    protected function downloadWithAPI(string $city): Response
    {
        $response = Http::get(str_replace('{slug}', $city, self::URL));
        $this->statusCode = $response->status();
        return $response;
    }
}
