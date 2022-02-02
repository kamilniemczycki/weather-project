<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\NotFoundLocation;
use App\Models\Bookmark;
use App\Models\Weather;
use App\Repository\Interfaces\WeatherAPI;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(): View
    {
        return view('search_page');
    }

    public function show(string $city, WeatherAPI $api): View
    {
        try {
            $city = Str::slug($city);
            $weather = $api->find($city);

            $bookmark = 'Add to bookmark';
            if (
                Auth::check() &&
                $this->isBookMark($city)
            ) {
                $bookmark = 'Remove with bookmark';
            }
        } catch (NotFoundLocation $e) {
            $bookmark = null;
            $weather = new Weather(['city' => $city]);
        }

        return view('search_page', compact('bookmark', 'weather'));
    }

    private function isBookMark(string $slugCity): bool
    {
        return Bookmark::query()
                ->where('location_slug', $slugCity)
                ->where('user_id', Auth::id())
                ->first() instanceof Bookmark;
    }
}
