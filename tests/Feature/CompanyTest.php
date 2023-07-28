<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Crypt;
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
            'email' => 'company@test.com',
            'password' => 'company'
        ];

        $this->post('/company/login', $credential)->assertRedirect(route('company.dashboard'));
    }

    public function test_company_dashboard_view()
    {
        $this->withoutExceptionHandling();

        $company = Company::where('id', '=', 1)->first();

        $this->actingAs($company, 'company');

        $this->get(route('company.dashboard'))->assertStatus(200);
    }

    public function test_company_view_cars()
    {
        $this->withoutExceptionHandling();

        $company = Company::where('id', '=', 1)->first();

        $this->actingAs($company, 'company');

        $this->get(route('company.index.car'))->assertStatus(200);
    }

    public function test_can_view_booking_types_in_car_add()
    {
        $this->withoutExceptionHandling();

        $company = Company::where('id', '=', 1)->first();

        $this->actingAs($company, 'company');

        $this->get(route('company.create.car'))->assertStatus(200);
    }

    public function test_company_view_reservations()
    {
        $this->withoutExceptionHandling();

        $company = Company::where('id', '=', 1)->first();

        $this->actingAs($company, 'company');

        $this->get(route('company.index.booking'))->assertStatus(200);
    }

    public function test_view_reservation_details()
    {
        $this->withoutExceptionHandling();

        $company = Company::where('id', '=', 1)->first();

        $this->actingAs($company, 'company');

        $this->get(route('company.show.booking', ['id' => 1]))->assertStatus(200);
    }

    public function test_edit_profile_view()
    {
        $this->withoutExceptionHandling();

        $company = Company::where('id', '=', 1)->first();

        $this->actingAs($company, 'company');

        $this->get(route('company.edit.profile', ['id' => Crypt::encrypt($company->id)]))->assertStatus(200);
    }

    public function test_can_edit_profile()
    {
        $this->withoutExceptionHandling();

        $company = Company::where('id', '=', 1)->first();

        $this->actingAs($company, 'company');

        $data = [
            'name' => 'test',
            'description' => 'test',
            'address' => 'test',
            'contact' => 'test',
            'registration_number' => 'test',
            'logo' => UploadedFile::fake()->image('avatar.jpg'),
        ];

        $this->json('POST', route('company.update.profile'), $data)->assertStatus(302);
    }

    public function test_can_view_notifications()
    {
        $this->withoutExceptionHandling();

        $company = Company::where('id', '=', 1)->first();

        $this->actingAs($company, 'company');

        $this->get(route('company.notification'))->assertStatus(200);
    }

    public function test_company_cars_add_form_view()
    {
        $this->withoutExceptionHandling();

        $company = Company::where('id', '=', 1)->first();

        $this->actingAs($company, 'company');

        $reponse = $this->get(route('company.create.car'))->assertStatus(200);
    }

    public function test_can_add_car()
    {
        $this->withoutExceptionHandling();

        $company = Company::where('id', '=', 1)->first();

        $this->actingAs($company, 'company');

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

        $this->json('POST', route('company.store.car'), $data)->assertStatus(302);
    }

    public function test_company_cars_edit_form_view()
    {
        $this->withoutExceptionHandling();

        $company = Company::where('id', '=', 1)->first();

        $this->actingAs($company, 'company');

        $this->get(route('company.edit.car', ['id' => Crypt::encrypt(1)]))->assertStatus(200);
    }

    public function test_can_edit_car_details()
    {
        $this->withoutExceptionHandling();

        $company = Company::where('id', '=', 1)->first();

        $this->actingAs($company, 'company');

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

        $this->json('POST', route('company.update.car', ['car-id' => 1, 'booking_type_id' => 1]), $data)->assertStatus(302);
    }

    public function test_company_delete_car()
    {
        $this->withoutExceptionHandling();

        $company = Company::where('id', '=', 2)->first();

        $this->actingAs($company, 'company');

        $this->get(route('company.delete.car', ['id' => 1]))->assertStatus(302);
    }
}
