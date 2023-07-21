<?php

namespace Database\Factories;

use App\Models\BookingType;
use App\Models\CarCompany;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'model' => $this->faker->word,
            'description' => $this->faker->word,
            'model_year' => $this->faker->year,
            'brand'=>$this->faker->word,
            'color'=>$this->faker->colorName,
            'primary_image' => "t",
            'plate_number' => $this->faker->word,
            'availability' => rand(0,1),
            'company_id' => CarCompany::all()->random()->id,
            'booking_type_id' => BookingType::all()->random()->id,
        ];
    }
}
