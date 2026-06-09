<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CitySeeder::class,
            UserSeeder::class,
            VenueSeeder::class,
            VenueBankAccountSeeder::class,
            VenueQrisSeeder::class,
            VenueImageSeeder::class,
            CourtMaterialSeeder::class,
            SportTypeSeeder::class,
            AdditionalTypeSeeder::class,
            CourtTypeSeeder::class,
            CourtSeeder::class,
            AdditionalSeeder::class,
            FacilityTypeSeeder::class,
            FacilitySeeder::class,
            OperationHourSeeder::class,
            LevelSeeder::class,
            CommunitySeeder::class,
            CommunityMemberSeeder::class,
            BookingSeeder::class,
            CancelRequestSeeder::class,
            RatingSeeder::class,
            WithdrawalSeeder::class,
            BalanceSeeder::class,
            StoreProductSeeder::class,
            StoreTransactionSeeder::class,
            EmployeeSeeder::class,
            UserRefundCreditSeeder::class
        ]);
    }
}
