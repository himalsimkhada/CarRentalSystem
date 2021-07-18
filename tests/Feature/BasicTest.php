<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BasicTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index()
    {
        $this->withoutExceptionHandling();

        $response = $this->get(route('index'));

        $response->assertStatus(200);
    }

    public function test_list_cars()
    {
        $this->withoutExceptionHandling();

        $data = [
            'pick_date' => '2021-06-06',
            'drop_date' => '2021-06-06',
            'location' => 'Gokarna',
            'type' => 'Normal'
        ];

        $this->json('POST', route('listing'), $data)->assertStatus(200);
    }

    public function test_car_listing()
    {
        $this->withoutExceptionHandling();

        $response = $this->get(route('cars.list'));

        $response->assertStatus(200);
    }

    public function test_pricedesc()
    {
        $this->withoutExceptionHandling();

        $response = $this->get(route('car.list.pricedesc'));

        $response->assertStatus(200);
    }
}
