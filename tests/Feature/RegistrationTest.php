<?php

namespace Tests\Feature;

use App\Models\User;
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
        $admin = User::whereIn('user_type', [1])->get();
        $this->withoutExceptionHandling();

        $credential = [
            'firstname' => 'Himal',
            'lastname' => 'Simkhada',
            'address' => 'Thali, KTM',
            'contact' => '000',
            'date_of_birth' => '2000-01-14',
            'email' => 'testhimal@test.com',
            'password' => 'himal1234',
            'password_confirmation' => 'himal1234',
            'username' => 'himal1234',
            'user_type' => 3,
        ];

        // event()

        $this->json('POST', route('register'), $credential)->assertStatus(201);
    }
}
