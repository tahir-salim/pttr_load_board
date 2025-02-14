<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name' => 'carrier',
                'promo_owner_amount' => 29.99,
                'promo_user_amount' => 19.99,
                'regular_owner_amount' => 99.99,
                'regular_user_amount' => 39.99,
            ],
            [
                'name' => 'broker',
                'promo_owner_amount' => 9.99,
                'promo_user_amount' => 9.99,
                'regular_owner_amount' => 49.99,
                'regular_user_amount' => 19.99,

            ],
        ];

        foreach ($packages as $key => $package) {
            Package::create($package);
        }
    }
}
