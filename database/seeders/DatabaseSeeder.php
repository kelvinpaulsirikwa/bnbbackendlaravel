<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            \Database\Seeders\BnbUserSeeder::class,
            \Database\Seeders\LocationSeeder::class,
            \Database\Seeders\HotelOwnerSeeder::class,
            \Database\Seeders\MotelTypeSeeder::class,
            \Database\Seeders\RoomTypeSeeder::class,
            \Database\Seeders\AmenitySeeder::class,
            \Database\Seeders\MotelSeeder::class,
            \Database\Seeders\BnbAmenitySeeder::class,
            \Database\Seeders\BnbAmenityImageSeeder::class,
            \Database\Seeders\BnbImageSeeder::class,
            \Database\Seeders\BnbRoomSeeder::class,
        ]);
    }
}
