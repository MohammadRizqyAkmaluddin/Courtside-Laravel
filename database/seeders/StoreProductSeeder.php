<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class StoreProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productGroups = [
            'racket-badmin' => ['racket-badmin1', 'racket-badmin2', 'racket-badmin3'],
            'racket-padel' => ['racket-padel1', 'racket-padel2', 'racket-padel3'],
            'racket-tennis' => ['racket-tennis1', 'racket-tennis2', 'racket-tennis3'],
            'tennis-ball' => ['tennis-ball1', 'tennis-ball2'],
            'bola-golf' => ['bola-golf1', 'bola-golf2'],
            'shin-pad' => ['shin-pad1', 'shin-pad2', 'shin-pad3'],

            // single
            'shuttlecock' => ['shuttlecock'],
            'bola-voli' => ['bola-voli'],
            'bola-basket' => ['bola-basket'],
            'bola-futsal' => ['bola-futsal'],
            'muscle-tape' => ['muscle-tape'],
            'shoes-futsal' => ['shoes-futsal'],
            'shoes-basket' => ['shoes-basket'],
            'shoes-football' => ['shoes-football'],

            // FNB
            'aqua' => ['aqua'],
            'aqua-gelas' => ['aqua-gelas'],
            'mizon' => ['mizon'],
            'pocari' => ['pocari'],
            'susu-ultramilk' => ['susu-ultramilk'],
            'susu-greenfield' => ['susu-greenfield'],
            'teh-pucuk' => ['teh-pucuk'],
            'kopi-hitam' => ['kopi-hitam'],
            'rotbak' => ['rotbak'],
            'sariroti' => ['sariroti'],
            'indomie' => ['indomie'],
            'popmie' => ['popmie'],
            'gorengan' => ['gorengan'],

            // 🔥 NEW PRODUCTS (no image)
            'grip-racket' => ['grip-racket'],
            'tas-raket' => ['tas-raket'],
            'handuk-olahraga' => ['handuk-olahraga'],
            'energy-bar' => ['energy-bar'],
            'isotonic-gel' => ['isotonic-gel'],
        ];

        $fnbList = [
            'aqua','aqua-gelas','mizon','pocari','susu-ultramilk','susu-greenfield',
            'teh-pucuk','kopi-hitam','rotbak','sariroti','indomie','popmie','gorengan',
            'energy-bar','isotonic-gel'
        ];

        $priceMap = [
            'racket-badmin1' => 150000,
            'racket-badmin2' => 200000,
            'racket-badmin3' => 250000,
            'racket-padel1' => 300000,
            'racket-padel2' => 350000,
            'racket-padel3' => 400000,
            'racket-tennis1' => 250000,
            'racket-tennis2' => 350000,
            'racket-tennis3' => 450000,
            'tennis-ball1' => 50000,
            'tennis-ball2' => 70000,
            'shuttlecock' => 40000,
            'bola-voli' => 120000,
            'bola-basket' => 180000,
            'bola-futsal' => 150000,
            'bola-golf1' => 80000,
            'bola-golf2' => 120000,
            'muscle-tape' => 25000,
            'shin-pad1' => 50000,
            'shin-pad2' => 70000,
            'shin-pad3' => 90000,
            'shoes-futsal' => 250000,
            'shoes-basket' => 350000,
            'shoes-football' => 300000,

            // FNB
            'aqua' => 5000,
            'aqua-gelas' => 1000,
            'mizon' => 8000,
            'pocari' => 10000,
            'susu-ultramilk' => 7000,
            'susu-greenfield' => 9000,
            'teh-pucuk' => 6000,
            'kopi-hitam' => 5000,
            'rotbak' => 15000,
            'sariroti' => 8000,
            'indomie' => 12000,
            'popmie' => 10000,
            'gorengan' => 5000,

            // 🔥 NEW PRICE
            'grip-racket' => 15000,
            'tas-raket' => 120000,
            'handuk-olahraga' => 30000,
            'energy-bar' => 12000,
            'isotonic-gel' => 15000,
        ];

        // 🔥 helper COGS generator
        $generateCogs = function ($price, $isFnb) {
            if ($isFnb) {
                return (int) ($price * rand(40, 60) / 100);
            }
            return (int) ($price * rand(60, 75) / 100);
        };

        $nameMap = [
            // RACKET
            'racket-badmin' => 'Yonex Badminton Racket',
            'racket-padel' => 'Adidas Padel Racket',
            'racket-tennis' => 'Wilson Tennis Racket',

            // BALLS
            'tennis-ball' => 'Wilson Tennis Ball Set',
            'bola-golf' => 'Titleist Golf Ball Pack',
            'bola-voli' => 'Mikasa Volleyball',
            'bola-basket' => 'Spalding Basketball',
            'bola-futsal' => 'Nike Futsal Ball',

            // EQUIPMENT
            'shuttlecock' => 'Yonex Shuttlecock',
            'shin-pad' => 'Nike Shin Guard',
            'muscle-tape' => 'Kinesio Muscle Tape',
            'shoes-futsal' => 'Nike Futsal Shoes',
            'shoes-basket' => 'Adidas Basketball Shoes',
            'shoes-football' => 'Puma Football Boots',

            // FNB
            'aqua' => 'Aqua Mineral Water Bottle 600ml',
            'aqua-gelas' => 'Aqua Cup Water 240ml',
            'mizon' => 'Mizone Isotonic Drink',
            'pocari' => 'Pocari Sweat 500ml',
            'susu-ultramilk' => 'Ultra Milk 250ml',
            'susu-greenfield' => 'Greenfields Fresh Milk',
            'teh-pucuk' => 'Teh Pucuk Harum 350ml',
            'kopi-hitam' => 'Black Coffee Cup',
            'rotbak' => 'Chocolate Toast Bread',
            'sariroti' => 'Sari Roti Sweet Bread',
            'indomie' => 'Indomie Instant Noodles',
            'popmie' => 'Pop Mie Instant Cup Noodles',
            'gorengan' => 'Fried Snack Assorted',

            // NEW
            'grip-racket' => 'Yonex Racket Grip',
            'tas-raket' => 'Li-Ning Racket Bag',
            'handuk-olahraga' => 'Nike Sports Towel',
            'energy-bar' => 'Fitbar Energy Bar',
            'isotonic-gel' => 'Isotonic Energy Gel',
        ];

        $data = [];

        for ($venueId = 1; $venueId <= 49; $venueId++) {

            $selectedGroups = Arr::random(array_keys($productGroups), rand(15, 22));

            foreach ($selectedGroups as $group) {

                $product = Arr::random($productGroups[$group]);
                $price = $priceMap[$product];
                $isFnb = in_array($group, $fnbList);

                $data[] = [
                    'venue_id' => $venueId,
                    'product_type' => $isFnb ? 'Fnb' : 'Gear',
                    'name' => $nameMap[$group] ?? ucwords(str_replace('-', ' ', $group)),
                    'price' => $price,
                    'cogs' => $generateCogs($price, $isFnb), // ✅ NEW
                    'stock' => $isFnb ? rand(20, 100) : rand(5, 30),
                    'image' => str_contains($product, 'grip') ||
                            str_contains($product, 'tas') ||
                            str_contains($product, 'handuk') ||
                            str_contains($product, 'energy') ||
                            str_contains($product, 'gel')
                            ? null
                            : $product . '.jpg',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('store_products')->insert($data);
    }
}
