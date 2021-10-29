<?php

namespace Tests\Unit;

use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * @return void
     */
    public function test_login_page()
    {
        $this->get('/login')->assertStatus(200);
    }

    /**
     * @return void
     */
    public function test_register_page()
    {
        $this->get('/register')->assertStatus(200);
    }
}
