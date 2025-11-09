<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoomType;

class RoomTypeSeeder extends Seeder
{
    public function run()
    {
        $roomTypes = [
            [
                'name' => 'Single Room',
                'description' => 'A room with one single bed',
                'createdby' => 1,
            ],
            [
                'name' => 'Double Room',
                'description' => 'A room with one double bed',
                'createdby' => 1,
            ],
            [
                'name' => 'Twin Room',
                'description' => 'A room with two single beds',
                'createdby' => 1,
            ],
            [
                'name' => 'Master Suite',
                'description' => 'A luxurious suite with master bedroom',
                'createdby' => 1,
            ],
            [
                'name' => '1 Bedroom',
                'description' => 'One bedroom apartment/unit',
                'createdby' => 1,
            ],
            [
                'name' => '2 Bedroom',
                'description' => 'Two bedroom apartment/unit',
                'createdby' => 1,
            ],
            [
                'name' => '3 Bedroom',
                'description' => 'Three bedroom apartment/unit',
                'createdby' => 1,
            ],
            [
                'name' => 'Family Room',
                'description' => 'Large room suitable for families',
                'createdby' => 1,
            ],
            [
                'name' => 'Deluxe Room',
                'description' => 'Premium room with extra amenities',
                'createdby' => 1,
            ],
            [
                'name' => 'Presidential Suite',
                'description' => 'The most luxurious suite available',
                'createdby' => 1,
            ],
        ];

        foreach ($roomTypes as $type) {
            RoomType::create($type);
        }
    }
}