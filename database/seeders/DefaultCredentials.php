<?php

namespace Database\Seeders;

use App\Models\BookingType;
use App\Models\Car;
use App\Models\CarCompany;
use App\Models\Location;
use App\Models\PartnerReq;
use App\Models\User;
use Illuminate\Database\Seeder;

class DefaultCredentials extends Seeder
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
                'firstname' => 'admin-fname',
                'lastname' => 'admin-lname',
                'address' => 'admin-address',
                'contact' => 'admin-contact',
                'date_of_birth' => date("Y-m-d"),
                'profile_photo' => '',
                'username' => 'admin',
                'email' => 'admin@test.com',
                'user_type' => '1',
                'password' => bcrypt('admin'),
            ],
            [
                'firstname' => 'admin-fname',
                'lastname' => 'admin-lname',
                'address' => 'admin-address',
                'contact' => 'admin-contact',
                'date_of_birth' => date("Y-m-d"),
                'profile_photo' => '',
                'username' => 'admin',
                'email' => 'testing@test.com',
                'user_type' => '1',
                'password' => bcrypt('admin'),
            ],
            [
                'firstname' => 'owner-company1',
                'lastname' => 'owner-company1',
                'address' => 'owner-company1',
                'contact' => 'owner-company1',
                'date_of_birth' => date("Y-m-d"),
                'profile_photo' => '',
                'username' => 'ownercom1',
                'email' => 'ownercom1@test.com',
                'user_type' => '2',
                'password' => bcrypt('owner'),
            ],
            [
                'firstname' => 'owner-company2',
                'lastname' => 'owner-company2',
                'address' => 'owner-company2',
                'contact' => 'owner-company2',
                'date_of_birth' => date("Y-m-d"),
                'profile_photo' => '',
                'username' => 'ownercom2',
                'email' => 'ownercom2@test.com',
                'user_type' => '2',
                'password' => bcrypt('owner'),
            ],
            [
                'firstname' => 'Himal',
                'lastname' => 'Simkhada',
                'address' => 'Thali',
                'contact' => 'not-provided',
                'date_of_birth' => date("Y-m-d"),
                'profile_photo' => '',
                'username' => 'himalsim',
                'email' => 'himal@test.com',
                'user_type' => '3',
                'password' => bcrypt('user'),
            ],
            [
                'firstname' => 'Saral',
                'lastname' => 'Raut',
                'address' => 'Balkot',
                'contact' => 'not-provided',
                'date_of_birth' => date("Y-m-d"),
                'profile_photo' => '',
                'username' => 'saralraut',
                'email' => 'saral@test.com',
                'user_type' => '3',
                'password' => bcrypt('user'),
            ],
            [
                'firstname' => 'Saral',
                'lastname' => 'Raut',
                'address' => 'Balkot',
                'contact' => 'not-provided',
                'date_of_birth' => date("Y-m-d"),
                'profile_photo' => '',
                'username' => 'saralraut123',
                'email' => 'saral@testtest.com',
                'user_type' => '3',
                'password' => bcrypt('user'),
            ],
        ];

        foreach ($user_credentails as $key => $value) {
            User::create($value);
        }

        $booking_types = [
            [
                'name' => 'Luxurious',
                'luggage_no' => 4,
                'people_no' => 4,
                'cost' => 100.00,
                'late_fee' => 40.00,
            ],
            [
                'name' => 'Supercar',
                'luggage_no' => 2,
                'people_no' => 2,
                'cost' => 200.00,
                'late_fee' => 80.00,
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
                'email' => 'company1@test.com',
                'logo' => '',
                'owner_id' => 3
            ],
            [
                'name' => 'Company 2',
                'description' => 'desc-company2',
                'address' => 'Bhaktapur',
                'contact' => 'contact-company2',
                'registration_number' => '1122334456',
                'email' => 'company2@test.com',
                'logo' => '',
                'owner_id' => 4
            ]
        ];

        foreach ($company_credentials as $key => $value) {
            CarCompany::create($value);
        }

        $locations = [
            [
                'location' => 'Ratnapark',
                'company_id' => 1
            ],
            [
                'location' => 'Gokarna',
                'company_id' => 1
            ],
            [
                'location' => 'Balaju',
                'company_id' => 1
            ],
            [
                'location' => 'Sankhu',
                'company_id' => 1
            ],
            [
                'location' => 'Balkot',
                'company_id' => 2
            ],
            [
                'location' => 'Suryabinayak',
                'company_id' => 2
            ],
            [
                'location' => 'Dhulikhel',
                'company_id' => 2
            ],
            [
                'location' => 'Sangha',
                'company_id' => 2
            ],
        ];

        foreach ($locations as $key => $value) {
            Location::create($value);
        }

        $cars = [
            [
                'model' => 'R8',
                'description' => 'The Audi R8 is a mid-engine, 2-seater sports car, which uses Audis trademark quattro permanent all-wheel drive system. It was introduced by the German car manufacturer Audi AG in 2006.',
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
                'description' => 'desc',
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
                'description' => 'desc',
                'model_year' => 2015,
                'brand' => 'Hundyai',
                'color' => 'Red',
                'plate_number' => 'GSD 677',
                'availability' => 1,
                'company_id' => 2,
                'booking_type_id' => 2,
            ],
            [
                'model' => 'Santro',
                'description' => 'desc',
                'model_year' => 2009,
                'brand' => 'Hundyai',
                'color' => 'Blue',
                'plate_number' => 'GSD 676',
                'availability' => 1,
                'company_id' => 1,
                'booking_type_id' => 3,
            ],
            [
                'model' => 'Maruti',
                'description' => 'desc',
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

        $data = [
            [
                'company_name' => 'testing',
                'company_description' => 'test',
                'company_address' => 'test',
                'company_contact' => 'test',
                'company_reg' => '1234',
                'company_email' => 'test@email.com',
                'user_id' => 7,
                'approved' => 'waiting'
            ],
            [
                'company_name' => 'testing',
                'company_description' => 'test',
                'company_address' => 'test',
                'company_contact' => 'test',
                'company_reg' => '4567',
                'company_email' => 'test@test.com',
                'user_id' => 7,
                'approved' => 'waiting'
            ],
        ];

        foreach ($data as $key => $value) {
            PartnerReq::create($value);
        }
    }
}
