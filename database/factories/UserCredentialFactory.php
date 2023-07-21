<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserCredential>
 */
class UserCredentialFactory extends Factory
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
            'user_id' => User::all()->random()->id,
        ];
    }
}
