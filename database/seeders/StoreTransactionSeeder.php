<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StoreTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::disableQueryLog();
        $paymentMethods = ['Cash', 'Qris', 'Bank Transfer'];

        // ambil semua produk, group by venue_id
        $productsByVenue = DB::table('store_products')
            ->get()
            ->groupBy('venue_id');

        $transactions = [];
        $items = [];

        $transactionId = 1;

        // loop venue sampai 49
        for ($venueId = 1; $venueId <= 49; $venueId++) {

            // skip kalau venue ga punya produk
            if (!isset($productsByVenue[$venueId])) continue;

            // jumlah transaksi per venue (bisa lu gedein)
            $transactionCount = rand(50, 150);

            for ($i = 0; $i < $transactionCount; $i++) {

                $totalPrice = 0;

                $createdAt = Carbon::now()->subDays(rand(0, 365))
                    ->subHours(rand(0, 23))
                    ->subMinutes(rand(0, 59));

                // pilih random produk untuk transaksi ini
                $products = $productsByVenue[$venueId]->random(rand(1, min(5, count($productsByVenue[$venueId]))));

                foreach ($products as $product) {

                    $quantity = rand(1, 5);
                    $unitPrice = $product->price;
                    $subtotal = $unitPrice * $quantity;

                    $totalPrice += $subtotal;

                    $items[] = [
                        'store_transaction_id' => $transactionId,
                        'store_product_id' => $product->id,
                        'unit_price' => $unitPrice,
                        'quantity' => $quantity,
                        'subtotal' => $subtotal,
                    ];
                }

                $transactions[] = [
                    'id' => $transactionId,
                    'venue_id' => $venueId,
                    'total_price' => $totalPrice,
                    'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ];

                $transactionId++;
            }
        }

        // biar cepat insert bulk
       foreach (array_chunk($transactions, 1000) as $chunk) {
            DB::table('store_transactions')->insert($chunk);
        }

        // insert items per chunk (lebih kecil karena datanya lebih banyak)
        foreach (array_chunk($items, 1000) as $chunk) {
            DB::table('transaction_items')->insert($chunk);
        }
    }
}
