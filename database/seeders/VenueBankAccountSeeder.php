<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Venue;

class VenueBankAccountSeeder extends Seeder
{
    public function run(): void
    {
        $banks = [
            'BCA',
            'Mandiri',
            'BRI',
            'BNI',
            'BTN',
            'BSI',
            'Cimb Niaga',
            'Permata',
            'Danamon'
        ];

        $ewallets = [
            'Dana',
            'Gopay',
            'OVO',
            'ShopeePay',
            'LinkAja',
            'Sakuku'
        ];

        $names = [
            'Budi Santoso',
            'Andi Wijaya',
            'Siti Nurhaliza',
            'Dewi Lestari',
            'Rizky Pratama',
            'Agus Saputra',
            'Putri Maharani',
            'Fajar Nugroho',
            'Ahmad Hidayat',
            'Intan Permata'
        ];

        $venues = Venue::all();

        foreach ($venues as $venue) {
            $totalAccounts = rand(1, 3);
            $usedAccounts = [];
            $mainIndex = rand(0, $totalAccounts - 1);

            for ($i = 0; $i < $totalAccounts; $i++) {

                // Tentuin tipe account (Bank / E-Wallet)
                $accountType = rand(0, 1) ? 'Bank' : 'E-Wallet';

                do {
                    if ($accountType === 'E-Wallet') {
                        $accountNumber = $this->generatePhoneNumber();
                        $bankType = $ewallets[array_rand($ewallets)];
                    } else {
                        $accountNumber = $this->generateAccountNumber();
                        $bankType = $banks[array_rand($banks)];
                    }
                } while (in_array($accountNumber, $usedAccounts));

                $usedAccounts[] = $accountNumber;

                DB::table('venue_bank_accounts')->insert([
                    'venue_id' => $venue->id,
                    'holder_name' => $names[array_rand($names)],
                    'account_type' => $accountType,
                    'bank_account' => $accountNumber,
                    'bank_type' => $bankType,
                    'status' => ($i === $mainIndex) ? 'Main' : 'Other',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function generateAccountNumber()
    {
        return str_pad(rand(0, 9999999999), 10, '0', STR_PAD_LEFT);
    }

    private function generatePhoneNumber()
    {
        return '08' . rand(100000000, 999999999); // total 10-12 digit
    }
}
