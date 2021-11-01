<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\NotFoundLocation;
use App\Interfaces\Weather;
use App\Models\Bookmark;
use App\src\Downloader\WeatherDownloader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookmarkController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, WeatherDownloader $weatherDownloader)
    {
        $bookmarks = $request->user()->bookmarks()->get();
        $allBookmarks = [];
        foreach ($bookmarks as $bookmark) {
            try {
                if ($weather = $this->getWeather($weatherDownloader, $bookmark->location_slug)) {
                    $allBookmarks[] = $weather;
                }
            } catch (NotFoundLocation $exception) {}
        }

        return view('bookmark', compact('allBookmarks'));
    }

    public function updateStatus(Request $request, string $slug)
    {
        $slug = Str::slug($slug);
        $user = $request->user();

        $bookmark = Bookmark::where('location_slug', $slug)->where('user_id', $user->id)->first();
        if ($bookmark) {
            $bookmark->delete();
        } else {
            Bookmark::create([
                'location_slug' => $slug,
                'user_id' => (int)$user->id
            ]);
        }

        return redirect(route('search.show', ['city' => $slug]))
            ->with('status', 'Update status for '. $slug);
    }

    /**
     * @throws \App\Exceptions\NotFoundLocation
     */
    private function getWeather(WeatherDownloader $weatherDownloader, string $slug): Weather
    {
        return $weatherDownloader->searchWeather($slug);
    }
}
