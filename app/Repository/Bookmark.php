<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\User;
use App\Repository\Interfaces\Bookmark as BookmarkInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use App\Models\Bookmark as BookmarkModel;

class Bookmark implements BookmarkInterface
{

    public function __construct(
        private BookmarkModel $bookmark
    ) {}

    public function get(User $user, string $slug): BookmarkModel|null
    {
        return $this->bookmark
            ->query()
            ->where('location_slug', $slug)
            ->where('user_id', $user->id)
            ->first();
    }

    public function create(User $user, string $slug)
    {
        $this->bookmark
            ->query()
            ->create([
                'location_slug' => $slug,
                'user_id' => (int)$user->id
            ]);
    }

    public function allForUser(User $user): Collection
    {
        return $user->bookmarks()->get();
    }

    public function isBookmark(User $user, string $slug): bool
    {
        return $this->bookmark
                ->query()
                ->where('location_slug', $slug)
                ->where('user_id', Auth::id())
                ->first() instanceof $this->bookmark;
    }

}
