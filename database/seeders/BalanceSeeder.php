<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BalanceSeeder extends Seeder
{
     public function run()
    {
        // =========================
        // 🔥 PLATFORM INCOME (5%)
        // =========================
        $platformIncome = DB::table('bookings as b')
            ->leftJoin('cancel_requests as cr', 'b.id', '=', 'cr.booking_id')
            ->whereDate('b.booking_date', '<=', now()->toDateString())
            ->where(function ($q) {

                // ✅ Confirmed langsung lolos (tanpa peduli cancel_request)
                $q->where('b.status', 'Confirmed')

                // ✅ Canceled + refund valid
                ->orWhere(function ($q2) {
                    $q2->where('b.status', 'Canceled')
                    ->whereNotNull('cr.id') // 🔥 penting
                    ->where('cr.status', 'Accepted')
                    ->whereRaw('cr.total_refund < b.total_price');
                });

            })
            ->sum(DB::raw('
                CASE
                    WHEN b.status = "Confirmed"
                        THEN b.total_price * 0.05

                    WHEN b.status = "Canceled"
                        THEN (b.total_price - COALESCE(cr.total_refund, 0)) * 0.05
                END
            '));
            DB::table('platform_balances')->insert([
                    'income' => $platformIncome,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

        // =========================
        // 🔥 VENUE BALANCE (income - withdraw)
        // =========================
        $venues = DB::table('bookings as b')
            ->leftJoin('cancel_requests as cr', 'b.id', '=', 'cr.booking_id')
            ->select(
                'b.venue_id',
                DB::raw('
                    SUM(
                        CASE
                            WHEN b.status = "Confirmed"
                                THEN b.total_price * 0.95

                            WHEN b.status = "Canceled"
                                THEN (b.total_price - COALESCE(cr.total_refund, 0)) * 0.95
                        END
                    ) as total_income
                ')
            )
            ->whereDate('b.booking_date', '<=', now())
            ->where(function ($q) {

                $q->where('b.status', 'Confirmed')

                ->orWhere(function ($q2) {
                    $q2->where('b.status', 'Canceled')
                    ->where('cr.status', 'Accepted')
                    ->whereRaw('COALESCE(cr.total_refund, 0) < b.total_price');
                });

            })
            ->groupBy('b.venue_id')
            ->get();

        foreach ($venues as $venue) {

            // total withdraw venue
            $totalWithdraw = DB::table('withdrawal_histories')
                ->where('venue_id', $venue->venue_id)
                ->where('status', 'Success')
                ->sum('amount');

            $finalBalance = $venue->total_income - $totalWithdraw;

            DB::table('venue_balances')->insert([
                'venue_id' => $venue->venue_id,
                'balance'  => $finalBalance
            ]);
        }
    }
}
