<?php

namespace Tests\Feature;

use App\Models\BookingType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Crypt;
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

        $response = $this->get(route('admin.index.type'));

        $response->assertStatus(200);
    }

    public function test_admin_adds_booking_types()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 1)->first();

        $this->actingAs($user, 'api');

        $data = [
            'name' => 'Testing',
            'luggage_no' => 2,
            'people_no' => 4,
            'cost' => 300,
            'late_fee' => 2
        ];

        $this->json('POST', route('admin.store.type'), $data)->assertStatus(302);
    }

    public function test_admin_edits_booking_types()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 1)->first();

        $this->actingAs($user, 'api');

        $data = [
            'name' => 'Testing123',
            'luggage_no' => 2,
            'people_no' => 4,
            'cost' => 300,
            'late_fee' => 2
        ];

        $this->json('POST', route('admin.update.type', ['id' => Crypt::encrypt(1)]), $data)->assertStatus(302);
    }

    public function test_admin_deletes_type()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 1)->first();

        $this->actingAs($user, 'api');

        $this->get(route('admin.delete.type', ['id' => 6]))->assertStatus(200);
    }
}
