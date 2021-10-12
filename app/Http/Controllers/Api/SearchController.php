<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WeatherDownloader;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function show(string $city): JsonResponse
    {
        $city = Str::slug($city);

        $api = new WeatherDownloader();
        $api->searchWeather($city);
        $result = $api->getWeather();

        return response()->json((object)$result->getAll());
    }
}
