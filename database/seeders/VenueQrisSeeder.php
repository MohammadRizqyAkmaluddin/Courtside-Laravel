<?php

namespace Database\Seeders;

use App\Models\Venue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VenueQrisSeeder extends Seeder
{
    public function run(): void
    {
        $venues = Venue::all();

        foreach ($venues as $venue) {
            DB::table('venue_qris')->insert([
                'venue_id' => $venue->id,
                'image' => 'example-qris.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
