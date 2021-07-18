<?php

namespace Database\Factories;

use App\Models\CarCompany;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarCompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CarCompany::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->word,
            'address' => $this->faker->address,
            'contact' => 'contact-company2',
            'registration_number' => '1122334456',
            'email' => 'company2@test.com',
            'logo' => '',
            'owner_id' => '',
        ];
    }
}
