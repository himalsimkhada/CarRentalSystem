<?php

namespace Database\Seeders;

use App\Models\BookingType;
use Database\Factories\TestingFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        TestingFactory::new();
    }
}
