<?php

namespace Tests\Feature;

use App\Models\BookingType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookingTypeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_display_all_types_admin_panel()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 1)->first();

        $this->actingAs($user, 'api');

        $response = $this->get(route('admin.booking.types'));

        $response->assertStatus(200);
    }

    public function test_admin_adds_booking_types()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 1)->first();

        $this->actingAs($user, 'api');

        $data = [
            'name' => 'test',
            'luggage_no' => 2,
            'people_no' => 4,
            'cost' => 300,
            'late_fee' => 2
        ];

        $this->json('POST', route('admin.booking.type.add'), $data)->assertStatus(302);
    }

    public function test_admin_edits_booking_types()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 1)->first();

        $this->actingAs($user, 'api');

        $data = [
            'name' => 'testss',
            'luggage_no' => 2,
            'people_no' => 4,
            'cost' => 300,
            'late_fee' => 2
        ];

        $this->json('POST', route('admin.booking.type.edit', ['id' => 1]), $data)->assertStatus(302);
    }

    public function test_admin_deletes_type()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 1)->first();

        $this->actingAs($user, 'api');

        $this->get(route('admin.booking.type.delete', ['id' => 6]))->assertStatus(302);
    }
}
