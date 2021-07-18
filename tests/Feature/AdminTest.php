<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminTest extends TestCase
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
            'email' => 'admin@test.com',
            'password' => 'admin'
        ];

        $this->post('login', $credential)->assertRedirect(route('admin.dashboard'));
    }

    public function test_cars_list_view()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 1)->first();

        $this->actingAs($user, 'api');

        $this->get(route('admin.car.list'))->assertStatus(200);
    }

    public function test_admin_dashboard()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 1)->first();

        $this->actingAs($user, 'api');

        $this->get(route('admin.dashboard'))->assertStatus(200);
    }

    public function test_admin_reservation_page()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 1)->first();

        $this->actingAs($user, 'api');

        $this->get(route('admin.list.reservations'))->assertStatus(200);
    }

    public function test_admin_user_list()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 1)->first();

        $this->actingAs($user, 'api');

        $this->get(route('admin.user.list'))->assertStatus(200);
    }

    public function test_admin_company_list()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 1)->first();

        $this->actingAs($user, 'api');

        $this->get(route('admin.company.list'))->assertStatus(200);
    }

    public function test_admin_can_add_admins()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 1)->first();

        $this->actingAs($user, 'api');

        $data = [
            'firstname' => 'test',
            'lastname' => 'test',
            'contact' => 'test',
            'address' => 'test',
            'date_of_birth' => '2000-05-05',
            'email' => 'test@tes.com',
            'username' => 'yoho',
            'password' => '1234567890',
            'user_type' => 1
        ];

        $this->json('POST', route('admin.user.admin.add'), $data)->assertStatus(302);
    }

    public function test_admin_can_edit_admin()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 2)->first();

        $this->actingAs($user, 'api');

        $data = [
            'firstname' => 'testing',
            'lastname' => 'testing',
            'contact' => 'testing',
            'address' => 'testing',
            'date_of_birth' => date('Y-m-d'),
            'email' => 'test@testingunu.com',
            'username' => 'testingunique',
            'password' => '1234567890',
        ];

        $this->json('POST', route('admin.user.admin.edit', ['id' => 2]), $data)->assertStatus(302);
    }

    public function test_can_add_company()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 1)->first();

        $this->actingAs($user, 'api');

        $values = [
            'name' => 'unittesting',
            'description' => 'test',
            'address' => 'test',
            'contact' => 'test',
            'registration_number' => '122233343433',
            'email' => 'emailunique@email.com',
            'owner_id' => 6,
        ];

        $this->json('POST', route('admin.add.company'), $values)->assertStatus(302);
    }

    public function test_can_delete_company()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 1)->first();

        $this->actingAs($user, 'api');

        $this->get(route('admin.delete.company', ['id' => 24]))->assertStatus(302);
    }

    public function test_can_delete_cars()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 1)->first();

        $this->actingAs($user, 'api');

        $this->get(route('admin.delete.car', ['id' => 24]))->assertStatus(302);
    }

    public function test_can_delete_users()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 1)->first();

        $this->actingAs($user, 'api');

        $this->get(route('admin.delete.user', ['id' => 24]))->assertStatus(302);
    }

    public function test_can_view_notifications()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 1)->first();

        $this->actingAs($user, 'api');

        $this->get(route('admin.notification'))->assertStatus(200);
    }
}
