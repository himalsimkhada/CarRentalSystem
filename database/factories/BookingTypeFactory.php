<?php

namespace Database\Factories;

use App\Models\BookingType;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BookingType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'luggage_no' => $this->faker->randomDigit,
            'people_no' => $this->faker->randomDigit,
            'cost' => $this->faker->randomDigit,
            'late_fee' => $this->faker->randomDigit,
        ];
    }
}
