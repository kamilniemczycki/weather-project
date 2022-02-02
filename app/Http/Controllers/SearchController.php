<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\NotFoundLocation;
use App\Models\Weather;
use App\Repository\Interfaces\Bookmark;
use App\Repository\Interfaces\WeatherAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SearchController extends Controller
{

    public function __construct(
        private WeatherAPI $api,
        private Bookmark $bookmark
    ) {}

    public function index(): View
    {
        return view('search_page');
    }

    public function show(Request $request, string $city): View
    {
        try {
            $city = Str::slug($city);
            $weather = $this->api->find($city);

            $bookmark = 'Add to bookmark';
            if (
                Auth::check() &&
                $this->bookmark->isBookMark($request->user(), $city)
            ) {
                $bookmark = 'Remove with bookmark';
            }
        } catch (NotFoundLocation $e) {
            $bookmark = null;
            $weather = new Weather(['city' => $city]);
        }

        return view('search_page', compact('bookmark', 'weather'));
    }

}
