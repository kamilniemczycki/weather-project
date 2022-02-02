<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\NotFoundLocation;
use App\Repository\Bookmark as BookmarkRepository;
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
    public function __construct(
        private BookmarkRepository $bookmark
    ) {
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
        $allBookmarks = [];
        foreach ($this->bookmark->allForUser($request->user()) as $bookmark) {
            try {
                if ($weather = $api->find($bookmark->location_slug)) {
                    $allBookmarks[] = $weather;
                }
            } catch (NotFoundLocation $exception) {}
        }

        return view('bookmark', compact('allBookmarks'));
    }

    public function changeStatus(Request $request, string $slug): RedirectResponse
    {
        $slug = Str::slug($slug);
        $user = $request->user();

        $bookmark = $this->bookmark->get($user, $slug);
        if ($bookmark) {
            $bookmark->delete();
        } else {
            $this->bookmark->create($user, $slug);
        }

        return redirect(
            route('search.show', ['city' => $slug])
        )->with('status', 'Update status for '. $slug);
    }

}
