<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->word,
            'address' => $this->faker->address,
            'contact' => 'contact-company2',
            'registration_number' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'logo' => 'no',
        ];
    }
}
