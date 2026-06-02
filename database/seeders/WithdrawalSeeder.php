<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WithdrawalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $venues = DB::table('bookings')
            ->select(
                'venue_id',
                DB::raw('SUM(total_price * 0.95) as total_income')
            )
            ->whereDate('booking_date', '<=', now())
            ->where('status', 'Confirmed')
            ->groupBy('venue_id')
            ->get();

        foreach ($venues as $venue) {

            // Ambil semua rekening milik venue ini
            $bankAccounts = DB::table('venue_bank_accounts')
                ->where('venue_id', $venue->venue_id)
                ->pluck('id')
                ->toArray();

            // SAFETY: kalau belum ada rekening, skip
            if (empty($bankAccounts)) continue;

            // total withdraw = 50% - 70% dari income
            $withdrawTarget = $venue->total_income * (rand(50, 70) / 100);

            $withdrawn = 0;

            $withdrawCount = max(
                rand(20, 50),
                ceil($venue->total_income / 200000) // makin gede income makin banyak transaksi
            );

            for ($i = 0; $i < $withdrawCount; $i++) {

                if ($withdrawn >= $withdrawTarget) break;

                $remainingTarget = $withdrawTarget - $withdrawn;

                $min = min(50000, $remainingTarget);
                $rawAmount = rand($min, $remainingTarget);

                $amount = max(10000, round($rawAmount, -4));
                $amount = min($amount, $remainingTarget);

                if ($amount > $remainingTarget) {
                    $amount = $remainingTarget;
                }

                $daysAgo = pow(rand(0, 365), 1.5); // bias ke recent
                $createdAt = now()->subDays($daysAgo);
                $updatedAt = (clone $createdAt)->addMinutes(rand(0, 1440));

                DB::table('withdrawal_histories')->insert([
                    'venue_id' => $venue->venue_id,
                    'venue_bank_account_id' => $bankAccounts[array_rand($bankAccounts)],
                    'reference_id'  => $this->generateReferenceId(),
                    'amount'   => $amount,
                    'status'   => 'Success',
                    'created_at' => $createdAt,
                    'updated_at' => $updatedAt,
                ]);

                $withdrawn += $amount;
            }
        }
    }

    private function generateReferenceId()
    {
        do {
            $ref = sprintf(
                '%04d-%04d-%04d',
                rand(0, 9999),
                rand(0, 9999),
                rand(0, 9999)
            );
        } while (
            DB::table('withdrawal_histories')
                ->where('reference_id', $ref)
                ->exists()
        );

        return $ref;
    }



}
