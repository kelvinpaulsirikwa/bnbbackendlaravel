<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\BnbUser;

class HotelOwnerSeeder extends Seeder
{
    public function run()
    {
        $hotelOwners = [
            [
                'username' => 'ahmed_hassan',
                'useremail' => 'ahmed.hassan@hotelowner.com',
                'profileimage' => null,
                'password' => Hash::make('password123'),
                'telephone' => '+255712345678',
                'status' => 'active',
                'role' => 'bnbowner',
                'createdby' => 'system',
            ],
            [
                'username' => 'fatima_mohamed',
                'useremail' => 'fatima.mohamed@hotelowner.com',
                'profileimage' => null,
                'password' => Hash::make('password123'),
                'telephone' => '+255713456789',
                'status' => 'active',
                'role' => 'bnbowner',
                'createdby' => 'system',
            ],
            [
                'username' => 'john_mwamba',
                'useremail' => 'john.mwamba@hotelowner.com',
                'profileimage' => null,
                'password' => Hash::make('password123'),
                'telephone' => '+255714567890',
                'status' => 'active',
                'role' => 'bnbowner',
                'createdby' => 'system',
            ],
        ];

        foreach ($hotelOwners as $owner) {
            BnbUser::create($owner);
        }
    }
}