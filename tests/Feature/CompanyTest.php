<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CompanyTest extends TestCase
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
            'email' => 'ownercom1@test.com',
            'password' => 'owner'
        ];

        $this->post('login', $credential)->assertRedirect(route('company.dashboard'));
    }

    public function test_company_dashboard_view()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 3)->first();

        $this->actingAs($user, 'api');

        $this->get(route('company.dashboard'))->assertStatus(200);
    }

    public function test_company_view_cars()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 3)->first();

        $this->actingAs($user, 'api');

        $this->get(route('company.car.list'))->assertStatus(200);
    }

    public function test_can_view_booking_types_in_car_add()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 3)->first();

        $this->actingAs($user, 'api');

        $this->get(route('company.add.car.view'))->assertStatus(200);
    }

    public function test_company_view_reservations()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 3)->first();

        $this->actingAs($user, 'api');

        $this->get(route('company.list.reservations'))->assertStatus(200);
    }

    public function test_view_reservation_details()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 3)->first();

        $this->actingAs($user, 'api');

        $this->get(route('company.reservation.detail', ['reservation_id' => 1]))->assertStatus(200);
    }

    public function test_edit_profile_view()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 3)->first();

        $this->actingAs($user, 'api');

        $this->get(route('company.profile.edit'))->assertStatus(200);
    }

    public function test_can_edit_profile()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 3)->first();

        $this->actingAs($user, 'api');

        $data = [
            'name' => 'test',
            'description' => 'test',
            'address' => 'test',
            'contact' => 'test',
            'registration_number' => 'test',
            'logo' => UploadedFile::fake()->image('avatar.jpg'),
        ];

        $this->json('POST', route('company.profile.edited'), $data)->assertStatus(302);
    }

    public function test_can_view_notifications()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 3)->first();

        $this->actingAs($user, 'api');

        $this->get(route('company.notification'))->assertStatus(200);
    }

    public function test_company_cars_add_form_view()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 3)->first();

        $this->actingAs($user, 'api');

        $reponse = $this->get(route('company.add.car.view'))->assertStatus(200);
    }

    public function test_can_add_car()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 3)->first();

        $this->actingAs($user, 'api');

        $data = [
            'model' => 'test',
            'description' => 'test',
            'model_year' => '2001',
            'brand' => 'test',
            'color' => 'test',
            'plate_number' => 'test1244',
            'availability' => 1,
            'primary_image' => UploadedFile::fake()->image('avatar.jpg'),
            'company_id' => 1,
            'booking_type_id' => 1
        ];

        $this->json('POST', route('company.add.car'), $data)->assertStatus(302);
    }

    public function test_company_cars_edit_form_view()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 3)->first();

        $this->actingAs($user, 'api');

        $this->get(route('company.edit.view.car', ['edit-car' => 1]))->assertStatus(200);
    }

    public function test_can_edit_car_details()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 3)->first();

        $this->actingAs($user, 'api');

        $data = [
            'model' => 'test123',
            'description' => 'test',
            'model_year' => '2001',
            'brand' => 'test',
            'color' => 'test',
            'plate_number' => 'test124456',
            'availability' => 1,
            'company_id' => 1,
            'booking_type_id' => 1,
            'primary_image' => UploadedFile::fake()->image('avatar.jpg'),
        ];

        $this->json('POST', route('company.edit.car', ['car-id' => 1, 'booking_type_id' => 1]), $data)->assertStatus(302);
    }

    public function test_company_delete_car()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 3)->first();

        $this->actingAs($user, 'api');

        $this->get(route('company.delete.car', ['id' => 1]))->assertStatus(302);
    }
}
