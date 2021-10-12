<?php

namespace App\Http\Controllers;

use App\Interfaces\Weather;
use App\Models\Bookmark;
use App\Models\WeatherDownloader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function index()
    {
        $bookmarks = Bookmark::where('user_id', Auth::id())->get();
        $allBookmarks = [];
        foreach ($bookmarks as $bookmark) {
            if ($weather = $this->getWeather($bookmark->location_slug)) {
                $allBookmarks[] = $weather;
            }
        }

        return view('bookmark', compact('allBookmarks'));
    }

    public function updateStatus(Request $request, string $slug)
    {
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

    private function getWeather(string $slug): Weather
    {
        $api = new WeatherDownloader();
        $api->searchWeather($slug);
        return $api->getWeather();
    }
}
