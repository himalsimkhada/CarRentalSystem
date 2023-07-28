<?php

namespace Tests\Feature;

use App\Models\Company;
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

        $company = Company::where('id', '=', 1)->first();

        $this->actingAs($company, 'company');

        $data = [
            'car_id' => 2,
            'image' => UploadedFile::fake()->image('temp.jpg'),
        ];

        $this->json('POST', route('company.car.store.image', ['id' => 2]), $data)->assertStatus(302);
    }
}
