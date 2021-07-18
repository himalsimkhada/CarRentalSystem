<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CarImageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_add_car_images()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 3)->first();

        $this->actingAs($user, 'api');

        $data = [
            'car_id' => 2,
            'image' => UploadedFile::fake()->image('temp.jpg'),
        ];

        $this->json('POST', route('company.car.store.image', ['id' => 2]), $data)->assertStatus(302);
    }
}
