<?php

namespace App\Providers;

use App\Repository\Bookmark;
use App\Repository\Interfaces\Bookmark as BookmarkInterface;
use Illuminate\Support\ServiceProvider;

class BookmarkServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BookmarkInterface::class, Bookmark::class);
    }
}
