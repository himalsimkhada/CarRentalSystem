<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ErrorTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_Login()
    {
        $this->withoutExceptionHandling();

        $credential = [
            'email' => 'ownercom123@test.com',
            'password' => 'owner123'
        ];

        $this->post('login', $credential)->assertRedirect(route('login'));
    }
}
