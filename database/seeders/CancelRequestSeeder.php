<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\CancelRequest;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CancelRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // =========================
        // 1. REJECTED
        // =========================
        $rejectedBookings = Booking::where('booking_date', '<', Carbon::today())
            ->where('status', 'Confirmed')
            ->get();

        foreach ($rejectedBookings as $booking) {

            if (CancelRequest::where('booking_id', $booking->id)->exists()) {
                continue;
            }

            CancelRequest::create([
                'booking_id' => $booking->id,
                'status' => 'Rejected',
                'total_refund' => null,
                'created_at' => $booking->updated_at,
                'updated_at' => $booking->updated_at,
            ]);
        }

        // =========================
        // 2. ACCEPTED
        // =========================
        $acceptedBookings = Booking::where('booking_date', '<', Carbon::today())
            ->where('status', 'Canceled')
            ->get();

        foreach ($acceptedBookings as $booking) {

            if (CancelRequest::where('booking_id', $booking->id)->exists()) {
                continue;
            }

            CancelRequest::create([
                'booking_id' => $booking->id,
                'status' => 'Accepted',
                'total_refund' => $this->generateRefund($booking),
                'created_at' => $booking->updated_at,
                'updated_at' => $booking->updated_at,
            ]);
        }

        // =========================
        // 3. REQUESTED
        // =========================
        $requestedBookings = Booking::where('booking_date', '>=', Carbon::today()->addDays(2))
            ->get();

        foreach ($requestedBookings as $booking) {

            if (CancelRequest::where('booking_id', $booking->id)->exists()) {
                continue;
            }

            CancelRequest::create([
                'booking_id' => $booking->id,
                'status' => 'Requested',
                'total_refund' => null,
                'created_at' => $booking->updated_at,
                'updated_at' => $booking->updated_at,
            ]);
        }
    }

    /**
     * Generate refund berdasarkan jarak hari
     */
    private function generateRefund($booking)
    {
        $daysDiff = Carbon::parse($booking->booking_date)->diffInDays(now());

        if ($daysDiff >= 3) {
            $percentage = rand(80, 100);
        } else {
            $percentage = rand(40, 70);
        }

        return intval(($percentage / 100) * $booking->total_price);
    }
}
