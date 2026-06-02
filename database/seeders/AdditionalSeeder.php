<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdditionalSeeder extends Seeder
{
    public function run(): void
    {
        $courts = DB::table('courts')->get();

        // cache biar cepat
        $additionalMap = DB::table('additional_types')
            ->get()
            ->groupBy('sport_type_id');

        $rows = [];

        foreach ($courts as $court) {

            $types = $additionalMap[$court->sport_type_id] ?? collect();

            if ($types->isEmpty()) continue;

            // jumlah tambahan random tapi masuk akal
            $take = rand(3, min(8, $types->count()));

            $selected = $types->random($take);

            foreach ($selected as $type) {
                $rows[] = [
                    'court_id' => $court->id,
                    'additional_type_id' => $type->id,
                    'description' => $this->generateDescription($type->addon),
                    'price' => $this->generatePrice($type->addon),
                ];
            }
        }

        DB::table('additionals')->insert($rows);
    }

    private function roundPrice($price, $nearest = 5000)
    {
        return floor($price / $nearest) * $nearest;
    }

    private function generatePrice($addon)
    {
        return $this->roundPrice(match ($addon) {
            'Coach', 'Personal Trainer', 'Instructor' => rand(150000, 400000),
            'Photographer', 'Video Highlight' => rand(200000, 500000),
            'Referee' => rand(100000, 250000),
            'Medical Team' => rand(150000, 350000),
            'Ball Boy' => rand(50000, 120000),
            'Racket', 'Ball', 'Shuttlecock' => rand(20000, 60000),
            'Jersey Rental' => rand(50000, 150000),
            'Golf Cart' => rand(150000, 300000),
            'Club Rental' => rand(100000, 250000),
            'Match Organizer' => rand(250000, 600000),
            default => rand(30000, 150000),
        });
    }

    private function generateDescription($addon)
    {
        $descriptions = [
            'Coach' => [
                'Coach profesional yang siap membantu meningkatkan performa permainan anda selama sesi berlangsung.',
                'Dapatkan bimbingan langsung dari coach berpengalaman untuk latihan yang lebih efektif dan terarah.',
            ],
            'Ball Boy' => [
                'Ball boy standby selama pertandingan untuk menjaga alur permainan tetap lancar tanpa gangguan.',
                'Direkomendasikan untuk pertandingan serius agar permainan tetap fokus dan efisien.',
            ],
            'Racket' => [
                'Mendapatkan sepasang raket berkualitas yang siap digunakan selama sesi bermain berlangsung.',
                'Raket disediakan dalam kondisi prima untuk menunjang kenyamanan permainan anda.',
            ],
            'Photographer' => [
                'Dokumentasikan momen terbaik anda dengan fotografer profesional selama sesi berlangsung.',
                'Cocok untuk event atau pertandingan penting agar setiap momen terekam dengan maksimal.',
            ],
            'Referee' => [
                'Wasit profesional untuk memastikan pertandingan berjalan adil dan sesuai aturan.',
                'Direkomendasikan untuk pertandingan kompetitif dengan standar permainan resmi.',
            ],
            'Medical Team' => [
                'Tim medis standby untuk memastikan keamanan dan penanganan cepat selama pertandingan.',
                'Memberikan rasa aman ekstra terutama untuk pertandingan intensitas tinggi.',
            ],
            'Video Highlight' => [
                'Dapatkan video highlight pertandingan anda yang siap dibagikan ke sosial media.',
                'Cocok untuk mengabadikan momen penting dalam bentuk video profesional.',
            ],
            'Match Organizer' => [
                'Tim organizer akan membantu mengatur jalannya pertandingan dari awal hingga selesai.',
                'Solusi praktis untuk event tanpa perlu repot mengatur teknis pertandingan.',
            ],
            'default' => [
                'Fasilitas tambahan untuk meningkatkan kenyamanan dan pengalaman bermain anda.',
                'Tambahan layanan yang dirancang untuk membuat sesi bermain lebih maksimal.',
            ]
        ];

        $list = $descriptions[$addon] ?? $descriptions['default'];

        return $list[array_rand($list)];
    }
}
