<?php

namespace Tests\Unit;

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
}
