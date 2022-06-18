<?php

declare(strict_types=1);

namespace App\Repository\Interfaces;

use App\Models\Bookmark as BookmarkModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface Bookmark
{

    public function allForUser(User $user): Collection;
    public function isBookmark(User $user, string $slug): bool;
    public function get(User $user, string $slug): BookmarkModel|null;

}
