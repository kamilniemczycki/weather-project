<?php

declare(strict_types=1);

namespace App\Repository;

use App\Exceptions\NotFoundLocation;
use App\Models\Weather;
use App\Repository\Interfaces\WeatherAPI as WeatherAPIInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class WeatherAPI implements WeatherAPIInterface
{
    private const URL = 'https://wttr.in/{slug}?format=j1';
    private int $statusCode = 200;

    /**
     * @throws NotFoundLocation
     */
    public function find(string $slug_name): Weather
    {
        $cacheName = "search:$slug_name";
        if (!Cache::has($cacheName)) {
            $response = $this->downloadWithAPI($slug_name);
            if(
                $this->statusCode() !== 200 ||
                ($responseJson = $response->json()) === null ||
                $responseJson === []
            ) throw new NotFoundLocation('The specified location was not found');

            $prepared = $this->prepareWeather(array_merge($responseJson, ['city' => $slug_name]));
            Cache::put($cacheName, $prepared, 3600);
        } else {
            $prepared = Cache::get($cacheName);
        }

        return $prepared;
    }

    private function prepareWeather(array $response): Weather
    {
        return new Weather([
            'city' => $response['city'],
            'country' => $response['nearest_area'][0]['country'][0]['value'],
            'weather_desc' => $response['current_condition'][0]['weatherDesc'][0]['value'],
            'temp_c' => $response['current_condition'][0]['temp_C'],
            'temp_f' => $response['current_condition'][0]['temp_F'],
        ]);
    }

    public function statusCode(): int
    {
        return $this->statusCode;
    }

    private function downloadWithAPI(string $city): Response
    {
        $response = Http::get(str_replace('{slug}', $city, self::URL));
        $this->statusCode = $response->status();
        return $response;
    }
}
