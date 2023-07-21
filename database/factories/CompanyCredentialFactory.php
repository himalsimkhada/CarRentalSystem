<?php

namespace Database\Factories;

use App\Models\CarCompany;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CompanyCredential>
 */
class CompanyCredentialFactory extends Factory
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
            'reg_number' => $this->faker->creditCardNumber,
            'file' => $this->faker->word,
            'image' => $this->faker->word,
            'company_id' => CarCompany::all()->random()->id,
        ];
    }
}
