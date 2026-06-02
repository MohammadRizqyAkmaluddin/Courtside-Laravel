<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EmployeeSeeder extends Seeder
{

    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');
        $venues = DB::table('venues')->pluck('id');

        $employees = [];

        foreach ($venues as $venueId) {

            $totalEmployees = rand(5, 10);

            $positions = [
                ['name' => 'Venue Manager', 'min' => 6000000, 'max' => 10000000],
                ['name' => 'Admin', 'min' => 3000000, 'max' => 5000000],
                ['name' => 'Cashier', 'min' => 3000000, 'max' => 4500000],
                ['name' => 'Customer Service', 'min' => 3000000, 'max' => 4500000],
                ['name' => 'Operational Staff', 'min' => 2800000, 'max' => 4000000],
                ['name' => 'Cleaning Service', 'min' => 2500000, 'max' => 3500000],
                ['name' => 'Security', 'min' => 3000000, 'max' => 4000000],
                ['name' => 'Technician', 'min' => 4000000, 'max' => 6000000],
                ['name' => 'Ball Boy', 'min' => 2000000, 'max' => 3000000],
                ['name' => 'Coach', 'min' => 4000000, 'max' => 7000000],
                ['name' => 'Photographer', 'min' => 3000000, 'max' => 5000000],
                ['name' => 'Promotion Staff', 'min' => 3000000, 'max' => 5000000],
            ];

            $religions = ['Islam', 'Christian', 'Catholic', 'Hindu', 'Buddha', 'Konghucu'];

            for ($i = 0; $i < $totalEmployees; $i++) {

                $pos = $positions[array_rand($positions)];

                // Gender
                $fakerGender = rand(0, 1) ? 'male' : 'female';
                $gender = $fakerGender === 'male' ? 'M' : 'F';

                // Name
                $name = $faker->name($fakerGender);

                // Salary
                $rawSalary = rand($pos['min'], $pos['max']);
                $salary = round($rawSalary / 500000) * 500000;

                // Phone
                $prefixes = ['081', '082', '083', '085', '087', '088'];
                $phoneNumber = $prefixes[array_rand($prefixes)] . $faker->numerify('#########');

                // 🎯 BOD (umur 18 - 50 tahun)
                $bod = $faker->dateTimeBetween('-50 years', '-18 years')->format('Y-m-d');

                // 🎯 Religion random
                $religion = $religions[array_rand($religions)];

                // 🎯 Hire date (created_at) random dalam 5 tahun terakhir
                $createdAt = $faker->dateTimeBetween('-5 years', 'now');

                $employees[] = [
                    'venue_id' => $venueId,
                    'name' => $name,
                    'gender' => $gender,
                    'position' => $pos['name'],
                    'salary' => $salary,
                    'phone_number' => $phoneNumber,
                    'bod' => $bod,
                    'religion' => $religion,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ];
            }
        }

        DB::table('employees')->insert($employees);
    }
}
