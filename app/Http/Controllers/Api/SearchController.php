<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotFoundLocation;
use App\Http\Controllers\Controller;
use App\Http\Resources\WeatherResource;
use App\Repository\Interfaces\WeatherAPI;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function show(string $city, WeatherAPI $api): JsonResponse
    {
        $city = Str::slug($city);
        try {
            $result = new WeatherResource($api->find($city));
        } catch (NotFoundLocation $notfound) {
            $result = (object)[
                'message' => $notfound->getMessage()
            ];
            $statusCode = 404;
        }

        return response()->json($result, $statusCode ?? 200);
    }
}
