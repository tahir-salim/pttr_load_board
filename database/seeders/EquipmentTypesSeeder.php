<?php

namespace Database\Seeders;

use App\Models\EquipmentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipmentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $equipmentTypes = [
            [
               'name'=>'Van',
               'prefix'=>'V',
               'is_active'=>1,
            ],
            [
                'name'=>'Flatbed',
                'prefix'=>'F',
                'is_active'=>1,
             ],
             [
                'name'=>'Auto Carrier',
                'prefix'=>'AC',
                'is_active'=>1,
             ],
        ];

        foreach ($equipmentTypes as $key => $equipmentType) {
            EquipmentType::create($equipmentType);
        }
    }
}
