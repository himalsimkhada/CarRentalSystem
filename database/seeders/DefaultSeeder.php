<?php

namespace Database\Seeders;

use App\Models\BookingType;
use App\Models\Car;
use App\Models\Company;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Seeder;

class DefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_credentails = [
            [
                'firstname' => 'Admin',
                'lastname' => 'Admin',
                'address' => 'Nepal',
                'contact' => 'N/A',
                'date_of_birth' => date("Y-m-d"),
                'profile_photo' => null,
                'username' => 'admin',
                'email' => 'admin@test.com',
                'user_type' => '1',
                'password' => bcrypt('admin'),
            ],
            [
                'firstname' => 'Normal',
                'lastname' => 'User',
                'address' => 'Thali',
                'contact' => 'not-provided',
                'date_of_birth' => date("Y-m-d"),
                'profile_photo' => null,
                'username' => 'user',
                'email' => 'user@test.com',
                'user_type' => '3',
                'password' => bcrypt('user'),
            ]
        ];

        foreach ($user_credentails as $key => $value) {
            User::create($value);
        }

        $booking_types = [
            [
                'name' => 'Luxurios',
                'luggage_no' => 2,
                'people_no' => 2,
                'cost' => 200.00,
                'late_fee' => 80.00,
            ],
            [
                'name' => 'Delux',
                'luggage_no' => 4,
                'people_no' => 4,
                'cost' => 100.00,
                'late_fee' => 40.00,
            ],
            [
                'name' => 'Normal',
                'luggage_no' => 4,
                'people_no' => 4,
                'cost' => 50.00,
                'late_fee' => 10.00,
            ],
            [
                'name' => 'Family',
                'luggage_no' => 8,
                'people_no' => 4,
                'cost' => 50.00,
                'late_fee' => 10.00,
            ],
        ];

        foreach ($booking_types as $key => $value) {
            BookingType::create($value);
        }

        $company_credentials = [
            [
                'name' => 'Company 1',
                'description' => 'desc-company1',
                'address' => 'Kathmandu',
                'contact' => 'contact-company1',
                'registration_number' => '1122334455',
                'email' => 'company@test.com',
                'password' => bcrypt('company'),
                'logo' => null,
            ]
        ];

        foreach ($company_credentials as $key => $value) {
            Company::create($value);
        }

        $locations = [
            [
                'name' => 'Ratnapark',
                'company_id' => 1
            ],
            [
                'name' => 'Gokarna',
                'company_id' => 1
            ],
            [
                'name' => 'Balaju',
                'company_id' => 1
            ],
            [
                'name' => 'Sankhu',
                'company_id' => 1
            ],
            [
                'name' => 'Balkot',
                'company_id' => 1
            ],
            [
                'name' => 'Suryabinayak',
                'company_id' => 1
            ],
            [
                'name' => 'Dhulikhel',
                'company_id' => 1
            ],
            [
                'name' => 'Sangha',
                'company_id' => 1
            ],
        ];

        foreach ($locations as $key => $value) {
            Location::create($value);
        }

        $cars = [
            [
                'model' => 'R8',
                'description' => 'The Audi R8 is a mid-engine, 2-seater sports car, which uses Audis trademark quattro permanent all-wheel drive system.',
                'model_year' => 2006,
                'brand' => 'Audi',
                'color' => 'Black',
                'plate_number' => 'GSD 678',
                'availability' => 1,
                'company_id' => 1,
                'booking_type_id' => 2,
            ],
            [
                'model' => 'Civic',
                'description' => 'It\'s fuel efficient, stylish, and fun to drive, all traits that make the 2024 Honda Civic a winner in our book.',
                'model_year' => 2010,
                'brand' => 'Honda',
                'color' => 'Silver',
                'plate_number' => 'GSD 679',
                'availability' => 1,
                'company_id' => 1,
                'booking_type_id' => 2,
            ],
            [
                'model' => 'Creta',
                'description' => 'The Hyundai Creta operates as a SUV and as such, it measures 4,300mm in length, 1,790mm in width, and 1,635mm in height.',
                'model_year' => 2015,
                'brand' => 'Hundyai',
                'color' => 'Red',
                'plate_number' => 'GSD 677',
                'availability' => 1,
                'company_id' => 1,
                'booking_type_id' => 2,
            ],
            [
                'model' => 'Santro',
                'description' => 'The Santro is a 5 seater 4 cylinder car and has length of 3610 mm, width of 1645 mm and a wheelbase of 2400 mm.',
                'model_year' => 2009,
                'brand' => 'Hundyai',
                'color' => 'Blue',
                'plate_number' => 'GSD 676',
                'availability' => 1,
                'company_id' => 1,
                'booking_type_id' => 3,
            ],
            [
                'model' => 'Alto 800',
                'description' => 'The Alto 800 is a 4 seater 3 cylinder car and has length of 3445mm, width of 1515mm and a wheelbase of 2360mm.',
                'model_year' => 2003,
                'brand' => 'Suzuki',
                'color' => 'White',
                'plate_number' => 'GSD 675',
                'availability' => 1,
                'company_id' => 1,
                'booking_type_id' => 4,
            ],
        ];

        foreach ($cars as $key => $value) {
            Car::create($value);
        }
    }
}
