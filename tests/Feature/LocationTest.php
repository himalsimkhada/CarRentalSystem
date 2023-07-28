<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Tests\TestCase;

class LocationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_location_view()
    {
        $this->withoutExceptionHandling();

        $company = Company::where('id', 1)->first();

        $this->actingAs($company, 'company');

        $this->get(route('company.index.location'))->assertStatus(200);
    }

    public function test_company_add_new_location()
    {
        $this->withoutExceptionHandling();

        $company = Company::where('id', 1)->first();

        $this->actingAs($company, 'company');

        $data = [
            'location' => 'test',
        ];

        $this->json('POST', route('company.store.location'), $data)->assertStatus(302);
    }

    public function test_location_edit()
    {
        $this->withoutExceptionHandling();

        $company = Company::where('id', 1)->first();

        $this->actingAs($company, 'company');

        $data = [
            'location' => 'test123',
        ];

        $this->json('POST', route('company.update.location', ['id' => 1]), $data)->assertStatus(302);
    }

    public function test_delete_location()
    {
        $this->withoutExceptionHandling();

        $company = Company::where('id', 1)->first();

        $this->actingAs($company, 'company');

        $this->get(route('company.delete.location', ['id' => 10]))->assertStatus(200);
    }
}
