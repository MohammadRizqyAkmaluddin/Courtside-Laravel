<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRefundCreditSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = DB::table('cancel_requests as cr')
            ->join('bookings as b', 'cr.booking_id', '=', 'b.id')
            ->select(
                'b.user_id',
                DB::raw('SUM(cr.total_refund) as total_credit')
            )
            ->where('cr.status', 'Accepted')
            ->whereNotNull('cr.total_refund')
            ->whereNotNull('b.user_id') // jaga2 guest booking
            ->groupBy('b.user_id')
            ->get();

        foreach ($data as $item) {

            // 🔥 prevent duplicate
            $exists = DB::table('user_refund_credits')
                ->where('user_id', $item->user_id)
                ->exists();

            if ($exists) continue;

            DB::table('user_refund_credits')->insert([
                'user_id' => $item->user_id,
                'total_credit' => $item->total_credit,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
