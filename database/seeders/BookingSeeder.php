<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BookingSeeder extends Seeder
{

    public function run()
    {
        // =========================
        // 🔥 CACHE SEMUA DATA
        // =========================
        $courtsByVenue = DB::table('courts')->get()->groupBy('venue_id');

        $operationMap = DB::table('operation_hours')
            ->where('is_closed', false)
            ->get()
            ->groupBy(fn($item) => $item->venue_id . '-' . $item->day_of_week);

        $additionalMap = DB::table('additionals')
            ->get()
            ->groupBy('court_id');

        $bookings = [];
        $sessions = [];
        $additions = [];

        $months = 12;


        $usedSessionsMap = [];
        // key: venue-court-date
        
        for ($m = 0; $m < $months; $m++) {

            $monthStart = now()->subMonths($m)->startOfMonth();
            $monthEnd   = (clone $monthStart)->endOfMonth();

            $dataPerMonth = rand(400, 550);

            for ($i = 0; $i < $dataPerMonth; $i++) {

            // =========================
            // 🔥 BOOKING DATE (PER DATA)
            // =========================
            $randomType = rand(1, 100);

            if ($randomType <= 50) {
                // 🔥 50% → HARI INI (dibanyakin)
                $bookingDate = now();

            } elseif ($randomType <= 75) {
                // 🔥 25% → H-1 sampai H-2
                $bookingDate = now()->subDays(rand(1, 2));

            } elseif ($randomType <= 85) {
                // 🔥 10% → H-3 sampai H-7
                $bookingDate = now()->subDays(rand(3, 7));

            } elseif ($randomType <= 95) {
                // 🔥 10% → DATA LAMA
                $bookingDate = $monthStart->copy()->addDays(
                    rand(0, $monthStart->diffInDays($monthEnd))
                );

            } else {
                // 🔥 5% → FUTURE
                $bookingDate = now()->addDays(rand(2, 5));
            }


            // =========================
            // 🔥 PAYMENT STATUS
            // =========================
            $paymentStatus = rand(1, 100) <= 5 ? 'Refund' : 'Paid';

            // future ga boleh refund (opsional tapi realistis)
            if ($bookingDate->isFuture()) {
                $paymentStatus = 'Paid';
            }

            $status = $paymentStatus === 'Refund' ? 'Canceled' : 'Confirmed';

                $venueId = rand(1, 30);

                $courts = $courtsByVenue[$venueId] ?? collect();
                if ($courts->isEmpty()) continue;

                $court = $courts->random();

                $dayOfWeek = $bookingDate->dayOfWeekIso;

                $operation = $operationMap[$venueId . '-' . $dayOfWeek][0] ?? null;
                if (!$operation) continue;

                $start = Carbon::parse($operation->open_time);
                $end   = Carbon::parse($operation->close_time);

                $sessionList = [];

                while ($start < $end) {
                    $sessionEnd = $start->copy()->addMinutes($court->session_duration);
                    if ($sessionEnd > $end) break;

                    $sessionList[] = [
                        'start_time' => $start->format('H:i:s'),
                        'end_time'   => $sessionEnd->format('H:i:s'),
                        'price'      => $court->price
                    ];

                    $start = $sessionEnd;
                }

                if (empty($sessionList)) continue;

                $key = $venueId . '-' . $court->id . '-' . $bookingDate->format('Y-m-d');

                // init kalau belum ada
                if (!isset($usedSessionsMap[$key])) {

                    $totalSessions = count($sessionList);

                    // sisain 2–5 slot kosong
                    $leaveEmpty = rand(2, min(5, $totalSessions - 1));

                    $maxUsed = $totalSessions - $leaveEmpty;

                    // ambil sesi yang akan dipakai hari itu
                    $usedSessionsMap[$key] = collect($sessionList)
                        ->shuffle()
                        ->take($maxUsed)
                        ->values();
                }

                // ambil 1–3 dari slot yang tersedia (biar tetep multi-booking)
                $availablePool = $usedSessionsMap[$key];

                if ($availablePool->isEmpty()) continue;

                $takeCount = rand(1, min(3, $availablePool->count()));

                $selectedSessions = $availablePool->splice(0, $takeCount)->values();

                $additionals = $additionalMap[$court->id] ?? collect();

                $selectedAdditionals = $additionals->isNotEmpty()
                    ? $additionals->shuffle()->take(rand(0, min(2, $additionals->count())))
                    : collect();

                $additionalTotal = $selectedAdditionals->sum('price');
                $price = round($selectedSessions->sum('price'), -4);

                $subtotal = $price + $additionalTotal;

                $admin_fee = 4000;
                $tax = $subtotal * 0.02;
                $total_price = $subtotal + $admin_fee + $tax;

                $createdAt = $monthStart->copy()->addSeconds(
                    rand(0, $monthStart->diffInSeconds($monthEnd))
                );

                $updatedAt = (clone $createdAt)->addMinutes(rand(0, 1440));

                // TEMP ID (index array)
                $bookingIndex = count($bookings);

                $bookings[] = [
                    'venue_id'   => $venueId,
                    'court_id'   => $court->id,
                    'user_id'    => rand(1, 35),
                    'booking_date' => $bookingDate->format('Y-m-d'),
                    'price'      => $subtotal,
                    'admin_fee'  => $admin_fee,
                    'tax'        => $tax,
                    'total_price'=> $total_price,
                    'midtrans_order_id' => 'ORDER-' . Str::uuid(),
                    'payment_status' => $paymentStatus,
                    'status'     => $status,
                    'code'       => strtoupper(Str::random(6)),
                    'created_at' => $createdAt,
                    'updated_at' => $updatedAt
                ];

                // simpan relasi sementara
                foreach ($selectedSessions as $s) {
                    $sessions[] = [
                        'booking_index' => $bookingIndex,
                        'start_time' => $s['start_time'],
                        'end_time'   => $s['end_time'],
                        'price'      => $s['price']
                    ];
                }

                foreach ($selectedAdditionals as $a) {
                    $additions[] = [
                        'booking_index' => $bookingIndex,
                        'additional_id' => $a->id,
                        'price' => $a->price
                    ];
                }
            }
        }

        // =========================
        // 🔥 BULK INSERT BOOKINGS
        // =========================
        DB::table('bookings')->insert($bookings);

        // ambil id terakhir
        $firstId = DB::getPdo()->lastInsertId();
        $ids = range($firstId, $firstId + count($bookings) - 1);

        // mapping index → id
        foreach ($sessions as &$s) {
            $s['booking_id'] = $ids[$s['booking_index']];
            unset($s['booking_index']);
        }

        foreach ($additions as &$a) {
            $a['booking_id'] = $ids[$a['booking_index']];
            unset($a['booking_index']);
        }

        DB::table('booking_sessions')->insert($sessions);
        DB::table('booking_additions')->insert($additions);
    }
}
