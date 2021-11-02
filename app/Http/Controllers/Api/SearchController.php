<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotFoundLocation;
use App\Http\Controllers\Controller;
use App\Interfaces\Downloader\WeatherDownloader;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function show(string $city, WeatherDownloader $api): JsonResponse
    {
        $city = Str::slug($city);

        try {
            $api->searchWeather($city);
            $result = $api->getWeather();
            $data = (object)$result->getAll();
        } catch (NotFoundLocation $notfound) {
            $data = (object)[
                'message' => $notfound->getMessage()
            ];
            $statusCode = 404;
        }

        return response()->json($data, $statusCode ?? 200);
    }
}
