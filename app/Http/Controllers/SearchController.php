<?php

namespace App\Http\Controllers;

use App\Models\WeatherDownloader;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(): View
    {
        return view('search_page');
    }

    public function show(string $city): View
    {
        $city = Str::slug($city);

        $api = new WeatherDownloader();
        $api->searchWeather($city);
        $result = $api->getWeather();

        return view('search_page', compact('result'));
    }
}
