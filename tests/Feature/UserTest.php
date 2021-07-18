<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UserTest extends TestCase
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
            'email' => 'himal@test.com',
            'password' => 'user'
        ];

        $this->post('login', $credential)->assertRedirect(route('index'));
    }

    public function test_can_view_notifications()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 5)->first();

        $this->actingAs($user, 'api');

        $this->get(route('user.notification'))->assertStatus(200);
    }

    public function test_can_view_user_profile()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 5)->first();

        $this->actingAs($user, 'api');

        $this->get(route('user.dashboard'))->assertStatus(200);
    }

    public function test_user_can_view_reservations()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 5)->first();

        $this->actingAs($user, 'api');

        $this->get(route('user.reservation'))->assertStatus(200);
    }

    public function test_user_can_view_edit_profile_page()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 5)->first();

        $this->actingAs($user, 'api');

        $this->get(route('user.profile.edit'))->assertStatus(200);
    }

    public function test_user_update_profile()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 5)->first();

        $this->actingAs($user, 'api');

        $data = [
            'firstname' => 'test',
            'lastname' => 'test',
            'address' => 'test',
            'contact' => 'test',
            'username' => 'test12'
        ];

        $this->json('POST', route('user.profile.edited'), $data)->assertStatus(302);
    }

    public function test_user_upload_picture()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 5)->first();

        $this->actingAs($user, 'api');

        $data = [
            'profile_photo' => UploadedFile::fake()->image('test.jpg'),
        ];

        $this->json('POST', route('user.profile.pic.edited'), $data)->assertStatus(302);
    }

    public function test_change_password()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 5)->first();

        $this->actingAs($user, 'api');

        $data = [
            'password' => 'nothing',
        ];

        $this->json('POST', route('password.change'), $data)->assertStatus(302);
    }
}
