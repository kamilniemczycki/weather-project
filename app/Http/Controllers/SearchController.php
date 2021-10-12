<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\WeatherDownloader;
use Illuminate\Support\Facades\Auth;
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

        $bookmark = 'Add to bookmark';
        if (
            Auth::check() &&
            Bookmark::where('location_slug', $city)->where('user_id', Auth::id())->first()
        ) {
            $bookmark = 'Remove with bookmark';
        }

        return view('search_page', compact('bookmark', 'city', 'result'));
    }
}
