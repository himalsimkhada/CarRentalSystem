<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'address' => $this->faker->address,
            'contact' => $this->faker->phoneNumber,
            'date_of_birth' => $this->faker->date('Y-m-d'),
            'email' => $this->faker->email,
            'password' => $this->faker->password,
            'username' => $this->faker->userName,
            'user_type' => 3
        ]; 
    }
}
