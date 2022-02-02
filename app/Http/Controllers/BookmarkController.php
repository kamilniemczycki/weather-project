<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\NotFoundLocation;
use App\Models\Bookmark;
use App\Models\Weather;
use App\Repository\Interfaces\WeatherAPI;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

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
     * @param Request $request
     * @param WeatherAPI $api
     * @return View
     */
    public function index(Request $request, WeatherAPI $api): View
    {
        $bookmarks = $request->user()->bookmarks()->get();
        $allBookmarks = [];
        foreach ($bookmarks as $bookmark) {
            try {
                if ($weather = $this->getWeather($api, $bookmark->location_slug)) {
                    $allBookmarks[] = $weather;
                }
            } catch (NotFoundLocation $exception) {}
        }

        return view('bookmark', compact('allBookmarks'));
    }

    public function updateStatus(Request $request, string $slug): RedirectResponse
    {
        $slug = Str::slug($slug);
        $user = $request->user();

        $bookmark = Bookmark::query()
            ->where('location_slug', $slug)
            ->where('user_id', $user->id)
            ->first();
        if ($bookmark) {
            $bookmark->delete();
        } else {
            Bookmark::query()->create([
                'location_slug' => $slug,
                'user_id' => (int)$user->id
            ]);
        }

        return redirect(route('search.show', ['city' => $slug]))
            ->with('status', 'Update status for '. $slug);
    }

    /**
     * @throws NotFoundLocation
     */
    private function getWeather(WeatherAPI $api, string $slug): Weather
    {
        return $api->find($slug);
    }
}
