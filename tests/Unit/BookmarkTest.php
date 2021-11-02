<?php

namespace Tests\Unit;

use App\Models\Bookmark;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookmarkTest extends TestCase
{
    use RefreshDatabase;
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
        $this->refreshDatabase();
        /** @var User $user */
        User::factory()->count(1)->create();
        $user = User::first();
        $user->bookmarks()->create([
            'location_slug' => 'legnica'
        ]);

        $bookmark = $user->bookmarks()->first();
        $this->assertEquals('legnica', $bookmark->location_slug);
    }

    public function test_remove_bookmark()
    {
        $this->refreshDatabase();
        /** @var User $user */
        User::factory()->count(1)->create();
        $user = User::first();
        $user->bookmarks()->create([
            'location_slug' => 'legnica'
        ]);

        $bookmark = Bookmark::first();

        $this->assertTrue($bookmark->delete());
    }
}
