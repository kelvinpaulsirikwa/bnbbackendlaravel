<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MotelType;

class MotelTypeSeeder extends Seeder
{
    public function run()
    {
        $motelTypes = [
            [
                'name' => 'Motel',
                'createby' => 'system',
            ],
            [
                'name' => 'Lodge',
                'createby' => 'system',
            ],
            [
                'name' => 'Resort',
                'createby' => 'system',
            ],
            [
                'name' => 'Inn',
                'createby' => 'system',
            ],
            [
                'name' => 'Guest House',
                'createby' => 'system',
            ],
            [
                'name' => 'Apartment',
                'createby' => 'system',
            ],
        ];

        foreach ($motelTypes as $type) {
            MotelType::create($type);
        }
    }
}