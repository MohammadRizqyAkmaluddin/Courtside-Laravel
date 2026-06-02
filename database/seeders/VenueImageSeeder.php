<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VenueImageSeeder extends Seeder
{
    public function run(): void
    {
        $venueImagesCount = [
            1 => 4,
            2 => 3,
            3 => 5,
            4 => 4,
            5 => 2,
            6 => 5,
            7 => 3,
            8 => 5,
            9 => 2,
            10 => 3,
            11 => 2,
            12 => 3,
            13 => 3,
            14 => 3,
            15 => 1,
            16 => 3,
            17 => 3,
            18 => 3,
            19 => 3,
            20 => 3,
            21 => 3,
            22 => 3,
            23 => 3,
            24 => 4,
            25 => 1,
            26 => 1,
            27 => 1,
            28 => 2,
            29 => 1,
            30 => 2,
            31 => 3,
            32 => 3,
            33 => 3,
            34 => 1,
            35 => 2,
            36 => 1,
            37 => 4,
            38 => 3,
            39 => 3,
            40 => 3,
            41 => 3,
            42 => 1,
            43 => 1,
            44 => 3,
            45 => 1,
            46 => 3,
            47 => 3,
            48 => 5,
            49 => 3,
        ];

        $data = [];

        foreach ($venueImagesCount as $venueId => $totalImages) {
            for ($i = 1; $i <= $totalImages; $i++) {
                $data[] = [
                    'venue_id'   => $venueId,
                    'image'      => "venue{$venueId}-{$i}.jpg",
                    'is_primary' => $i === 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }

        DB::table('venue_images')->insert($data);
    }
}
