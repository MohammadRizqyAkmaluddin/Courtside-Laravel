<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RatingSeeder extends Seeder
{
    public function run()
    {
        $bookings = DB::table('bookings')
            ->where('status', 'Confirmed')
            ->whereDate('booking_date', '<', now()->toDateString())
            ->get();

        foreach ($bookings as $booking) {

            $exists = DB::table('ratings')
                ->where('booking_id', $booking->id)
                ->exists();

            if ($exists) continue;

            // random skip (biar ga semua ada rating)
            if (rand(0, 1) == 0) continue;

            // random rate 3–5 (karena udah confirmed & selesai → biasanya bagus)
            $rate = rand(3, 5);

            // optional review (50% ada, 50% null)
            $review = rand(0, 1)
                ? $this->generateReview($rate)
                : null;

            DB::table('ratings')->insert([
                'booking_id' => $booking->id,
                'rate' => $rate,
                'review' => $review,
                'created_at' => $booking->booking_date,
                'updated_at' => $booking->booking_date,
            ]);
        }
    }

    private function generateReview($rate)
    {
        $reviews = [
            5 => [
                'Tempatnya keren banget, vibes-nya dapet parah! Definitely will come back again.',
                'Pelayanan mantap, staff-nya helpful dan ramah. Super recommended!',
                'Court bersih, lighting bagus, overall experience top tier sih.',
                'Gila sih ini venue, dari fasilitas sampai ambience semuanya premium feel.',
                'Best place to play so far, ga ada komplain sama sekali.',
                'Worth every penny, experience-nya satisfying banget!',
                'Booking gampang, tempat on time, no hassle at all. Love it!',
            ],
            4 => [
                'Bagus sih overall, cuma kadang agak rame aja.',
                'Nice place, cukup nyaman buat main walaupun ga perfect.',
                'Worth it lah dengan harga segini, masih oke banget.',
                'Tempatnya enak, cuma ada sedikit minus di waiting time.',
                'Good experience overall, bakal balik tapi mungkin pilih jam sepi.',
                'Fasilitas lengkap, tapi maintenance bisa lebih ditingkatin lagi.',
                'Pretty solid venue, minor issues tapi masih acceptable.',
            ],
            3 => [
                'Biasa aja sih, nothing special but still playable.',
                'Lumayan lah buat main, tapi ga terlalu standout.',
                'Average experience, ga jelek tapi ga wow juga.',
                'Tempat oke, tapi ada beberapa hal yang bisa diperbaiki.',
                'Not bad, but also not great. Middle aja lah.',
                'Cukup buat main bareng temen, tapi ga terlalu memorable.',
            ],
            2 => [
                'Kurang nyaman sih, banyak hal yang bikin kurang enjoy.',
                'Tempatnya agak kurang terawat, perlu improvement.',
                'Not really a good experience, mungkin ga balik lagi.',
                'Fasilitas kurang maksimal, agak kecewa jujur.',
                'Service kurang responsif, jadi agak ganggu experience.',
                'Expected more dari tempat ini, ternyata biasa aja bahkan cenderung kurang.',
            ],
            1 => [
                'Kecewa banget, totally not worth it.',
                'Ga sesuai ekspektasi sama sekali, kapok sih.',
                'Bad experience overall, banyak hal yang bermasalah.',
                'Tempat kurang bersih, service juga ga oke.',
                'Really disappointed, ga bakal balik lagi.',
                'Worst experience sejauh ini, mending cari tempat lain.',
            ],
        ];

        return collect($reviews[$rate])->random();
    }
}
