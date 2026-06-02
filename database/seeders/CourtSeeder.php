<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // venue_id => default sport_type_id
        $venueSportMap = [
            1 => 5, 2 => 5, 3 => 5, 4 => 5,
            5 => 4,
            6 => 6,
            7 => 11,
            8 => 5, 9 => 5, 10 => 5, 11 => 5,
            12 => 6, 13 => 6,
            14 => 4,
            15 => 2, 16 => 2,
            17 => 5,
            18 => 6, 19 => 6,
            20 => 5,
            21 => 3,
            22 => 7,
            23 => 5,
            24 => 7, 25 => 7,
            26 => 9,
            27 => 1,
            28 => 5,
            29 => 7,
            30 => 3,
        ];

        $courtNames = [
            'Black Mamba Court',
            'Blue Ocean Court',
            'Lava Court',
            'Sky Arena',
            'Court A',
            'Court B',
            'Court C',
            'Prime Court',
            'Elite Court',
            'Alpha Court',
            'Phoenix Court',
            'Nebula Court',
        ];

        // harga normal Indonesia
        $sportBasePrice = [
            1 => [300000, 600000],
            2 => [150000, 300000],
            3 => [120000, 250000],
            4 => [40000, 80000],
            5 => [200000, 400000],
            6 => [150000, 350000],
            7 => [150000, 300000],
            8 => [100000, 200000],
            9 => [200000, 500000],
            10 => [200000, 400000],
            11 => [150000, 300000],
        ];

        // mapping image per sport
        $sportImages = [
            1  => ['football', 5],
            2  => ['minisoccer', 5],
            3  => ['futsal', 5],
            4  => ['badminton', 10],
            5  => ['padel', 20],
            6  => ['tennis', 10],
            7  => ['basketball', 10],
            8  => ['volley', 10],
            9  => ['golf', 5],
            10 => ['baseball', 5],
            11 => ['softball', 5],
        ];

        $rows = [];

        $duration = 0;

        foreach ($venueSportMap as $venueId => $defaultSport) {
            $totalCourts = rand(2, 6);

            for ($i = 1; $i <= $totalCourts; $i++) {

                if ($defaultSport === 5) {
                    $sportTypeId = rand(1, 100) <= 70
                        ? 5
                        : array_rand($sportBasePrice);
                } else {
                    $sportTypeId = rand(1, 100) <= 75
                        ? $defaultSport
                        : array_rand($sportBasePrice);
                }

                [$min, $max] = $sportBasePrice[$sportTypeId] ?? [100000, 250000];

                $rawPrice = rand($min, $max);
                $price = floor($rawPrice / 5000) * 5000;

                if (isset($sportImages[$sportTypeId])) {
                    [$prefix, $maxImage] = $sportImages[$sportTypeId];
                    $image = $prefix . rand(1, $maxImage) . '.jpg';
                } else {
                    $image = 'default.jpg';
                }

                if ($sportTypeId <= 2 || $sportTypeId === 9) {
                    $duration = 120;
                } else {
                    $duration = 60;
                }

                $rows[] = [
                    'venue_id' => $venueId,
                    'sport_type_id' => $sportTypeId,
                    'court_type_id' => rand(1, 2),
                    'court_material_id' => rand(1, 3),
                    'name' => $courtNames[array_rand($courtNames)],
                    'price' => $price,
                    'image' => $image,
                    'session_duration' => $duration,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }
        DB::table('courts')->insert($rows);
    }

}
