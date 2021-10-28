<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundLocation;
use App\Interfaces\Downloader\WeatherDownloader;
use App\Interfaces\Weather;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(): View
    {
        return view('search_page');
    }

    public function show(string $city, WeatherDownloader $api): View
    {
        try {
            $city = Str::slug($city);
            $result = $api->searchWeather($city);

            $bookmark = 'Add to bookmark';
            if (
                Auth::check() &&
                $this->isBookMark($city)
            ) {
                $bookmark = 'Remove with bookmark';
            }
        } catch (NotFoundLocation $e) {
            $bookmark = null;
            $result = new \App\src\Weather($e->getMessage());
        }

        $city = $api->unSlugCity($city);

        return view('search_page', compact('bookmark', 'city', 'result'));
    }

    private function isBookMark(string $slugCity): bool
    {
        return Bookmark::where('location_slug', $slugCity)->where('user_id', Auth::id())->first() instanceof Bookmark;
    }
}
