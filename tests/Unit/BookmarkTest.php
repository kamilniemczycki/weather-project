<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class BookmarkTest extends TestCase
{
    /**
     * @return void
     */
    public function test_not_authorized_bookmark_page()
    {
        $this->get(route('bookmark.index'))->assertRedirect('/login');
    }

    /**
     * @return void
     */
    public function test_not_authorized_bookmark_update_status()
    {
        $this->post(route('bookmark.update', ['slug' => 'location']))->assertRedirect('/login');
    }

    public function test_add_bookmark()
    {
        /** @var User $user */
        User::factory()->count(1)->make();
        $user = User::first();
        $user->bookmarks()->make([
            'location_slug' => 'legnica'
        ]);

        $bookmark = $user->bookmarks()->first();
        $this->assertEquals('legnica', $bookmark->location_slug);
    }

    public function test_remove_bookmark()
    {
        /** @var User $user */
        User::factory()->count(1)->make();
        $user = User::first();
        $user->bookmarks()->make([
            'location_slug' => 'legnica'
        ]);

        $bookmark = $user->bookmarks()->first();

        $this->assertTrue($bookmark->delete());
    }
}
