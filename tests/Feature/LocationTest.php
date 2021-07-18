<?php

namespace Tests\Feature;

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

        $user = User::where('id', '=', 3)->first();

        $this->actingAs($user, 'api');

        $this->get(route('company.locations'))->assertStatus(200);
    }

    public function test_company_add_new_location()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 3)->first();

        $this->actingAs($user, 'api');

        $data = [
            'location' => 'test',
        ];

        $this->json('POST', route('company.location.add'), $data)->assertStatus(302);
    }

    public function test_location_edit()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 3)->first();

        $this->actingAs($user, 'api');

        $data = [
            'location' => 'test123',
        ];

        $this->json('POST', route('company.location.edit', ['id' => 1]), $data)->assertStatus(302);
    }

    public function test_delete_location()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 3)->first();

        $this->actingAs($user, 'api');

        $this->get(route('company.delete.location', ['id' => 10]))->assertStatus(302);
    }
}
