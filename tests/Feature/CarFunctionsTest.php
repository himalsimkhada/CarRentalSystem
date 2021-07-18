<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CarFunctionsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_view_car_details()
    {
        $this->withoutExceptionHandling();

        $data = [
            'pick_date' => '2021-06-06',
            'drop_date' => '2021-06-06',
            'type' => 'Supercar',
            'get_type' => 'Supercar',
        ];

        $reponse = $this->get(route('car.detail', ['car-id' => 2]), $data);
        $reponse->assertStatus(200);
    }

    public function test_can_view_by_category()
    {
        $this->withoutExceptionHandling();
        
        $this->get(route('car.category', ['type_id' => 1]))->assertStatus(200);
    }
}
