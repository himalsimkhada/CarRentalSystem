<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_register_user()
    {
        $this->withoutExceptionHandling();

        $credential = [
            'firstname' => 'Himal',
            'lastname' => 'Simkhada',
            'address' => 'Thali, KTM',
            'contact' => '000',
            'date_of_birth' => '2000-01-14',
            'email' => 'test@test.com',
            'password' => 'himal1234',
            'password_confirmation' => 'himal1234',
            'username' => 'himal123',
            'user_type' => 3,
        ];

        $this->json('POST', route('register'), $credential)->assertStatus(201);
    }
}
