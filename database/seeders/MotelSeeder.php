<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Motel;
use App\Models\MotelDetail;
use App\Models\BnbUser;
use App\Models\MotelType;
use Illuminate\Support\Facades\DB;

class MotelSeeder extends Seeder
{
    public function run()
    {
        // Get Dar es Salaam region ID
        $darEsSalaamRegionId = DB::table('regions')->where('name', 'Dar es Salaam')->value('id');
        
        // Get districts in Dar es Salaam
        $districts = DB::table('districts')
            ->where('regionid', $darEsSalaamRegionId)
            ->pluck('id')
            ->toArray();
        
        // Get hotel owners
        $owners = BnbUser::where('role', 'bnbowner')->pluck('id')->toArray();
        
        // Get motel types
        $motelTypes = MotelType::pluck('id')->toArray();
        
        $motels = [
            [
                'name' => 'Serena Hotel Dar es Salaam',
                'description' => 'Luxurious 5-star hotel in the heart of Dar es Salaam with world-class amenities and services.',
                'owner_id' => $owners[array_rand($owners)],
                'motel_type_id' => $motelTypes[array_rand($motelTypes)],
                'street_address' => 'Ohio Street, Dar es Salaam',
                'district_id' => $districts[array_rand($districts)],
                'latitude' => -6.7924,
                'longitude' => 39.2083,
                'front_image' => 'serena_hotel.jpg',
                'created_by' => 1,
                'details' => [
                    'contact_phone' => '+255222111234',
                    'contact_email' => 'info@serenahotels.com',
                    'total_rooms' => 150,
                    'available_rooms' => 120,
                    'status' => 'active'
                ]
            ],
            [
                'name' => 'Holiday Inn Dar es Salaam',
                'description' => 'Modern business hotel with excellent facilities and convenient location.',
                'owner_id' => $owners[array_rand($owners)],
                'motel_type_id' => $motelTypes[array_rand($motelTypes)],
                'street_address' => 'Kivukoni Front, Dar es Salaam',
                'district_id' => $districts[array_rand($districts)],
                'latitude' => -6.8206,
                'longitude' => 39.2886,
                'front_image' => 'holiday_inn.jpg',
                'created_by' => 1,
                'details' => [
                    'contact_phone' => '+255222123456',
                    'contact_email' => 'reservations@holidayinn-dar.com',
                    'total_rooms' => 200,
                    'available_rooms' => 180,
                    'status' => 'active'
                ]
            ],
            [
                'name' => 'Sea Cliff Hotel',
                'description' => 'Beachfront luxury resort with stunning ocean views and premium services.',
                'owner_id' => $owners[array_rand($owners)],
                'motel_type_id' => $motelTypes[array_rand($motelTypes)],
                'street_address' => 'Msasani Peninsula, Dar es Salaam',
                'district_id' => $districts[array_rand($districts)],
                'latitude' => -6.7500,
                'longitude' => 39.2500,
                'front_image' => 'sea_cliff.jpg',
                'created_by' => 1,
                'details' => [
                    'contact_phone' => '+255222134567',
                    'contact_email' => 'info@seacliffhotel.com',
                    'total_rooms' => 100,
                    'available_rooms' => 85,
                    'status' => 'active'
                ]
            ],
            [
                'name' => 'Kilimanjaro Kempinski Hotel',
                'description' => 'Elegant hotel offering exceptional hospitality and comfort in Dar es Salaam.',
                'owner_id' => $owners[array_rand($owners)],
                'motel_type_id' => $motelTypes[array_rand($motelTypes)],
                'street_address' => 'Kivukoni Front, Dar es Salaam',
                'district_id' => $districts[array_rand($districts)],
                'latitude' => -6.8200,
                'longitude' => 39.2900,
                'front_image' => 'kempinski.jpg',
                'created_by' => 1,
                'details' => [
                    'contact_phone' => '+255222145678',
                    'contact_email' => 'reservations@kempinski-dar.com',
                    'total_rooms' => 180,
                    'available_rooms' => 160,
                    'status' => 'active'
                ]
            ],
            [
                'name' => 'Hyatt Regency Dar es Salaam',
                'description' => 'Contemporary hotel with modern amenities and excellent service standards.',
                'owner_id' => $owners[array_rand($owners)],
                'motel_type_id' => $motelTypes[array_rand($motelTypes)],
                'street_address' => 'Kivukoni Front, Dar es Salaam',
                'district_id' => $districts[array_rand($districts)],
                'latitude' => -6.8150,
                'longitude' => 39.2850,
                'front_image' => 'hyatt.jpg',
                'created_by' => 1,
                'details' => [
                    'contact_phone' => '+255222156789',
                    'contact_email' => 'dar@hyatt.com',
                    'total_rooms' => 220,
                    'available_rooms' => 200,
                    'status' => 'active'
                ]
            ],
            [
                'name' => 'Southern Sun Dar es Salaam',
                'description' => 'Comfortable hotel with warm hospitality and convenient city center location.',
                'owner_id' => $owners[array_rand($owners)],
                'motel_type_id' => $motelTypes[array_rand($motelTypes)],
                'street_address' => 'Ohio Street, Dar es Salaam',
                'district_id' => $districts[array_rand($districts)],
                'latitude' => -6.7900,
                'longitude' => 39.2100,
                'front_image' => 'southern_sun.jpg',
                'created_by' => 1,
                'details' => [
                    'contact_phone' => '+255222167890',
                    'contact_email' => 'info@southernsun-dar.com',
                    'total_rooms' => 120,
                    'available_rooms' => 100,
                    'status' => 'active'
                ]
            ],
            [
                'name' => 'Mövenpick Hotel Dar es Salaam',
                'description' => 'Swiss hospitality with African charm in the heart of the city.',
                'owner_id' => $owners[array_rand($owners)],
                'motel_type_id' => $motelTypes[array_rand($motelTypes)],
                'street_address' => 'Kivukoni Front, Dar es Salaam',
                'district_id' => $districts[array_rand($districts)],
                'latitude' => -6.8250,
                'longitude' => 39.2950,
                'front_image' => 'movenpick.jpg',
                'created_by' => 1,
                'details' => [
                    'contact_phone' => '+255222178901',
                    'contact_email' => 'reservations@movenpick-dar.com',
                    'total_rooms' => 160,
                    'available_rooms' => 140,
                    'status' => 'active'
                ]
            ],
            [
                'name' => 'Golden Tulip Dar es Salaam',
                'description' => 'Modern hotel offering comfort and convenience for business and leisure travelers.',
                'owner_id' => $owners[array_rand($owners)],
                'motel_type_id' => $motelTypes[array_rand($motelTypes)],
                'street_address' => 'Ohio Street, Dar es Salaam',
                'district_id' => $districts[array_rand($districts)],
                'latitude' => -6.7850,
                'longitude' => 39.2050,
                'front_image' => 'golden_tulip.jpg',
                'created_by' => 1,
                'details' => [
                    'contact_phone' => '+255222189012',
                    'contact_email' => 'info@goldentulip-dar.com',
                    'total_rooms' => 90,
                    'available_rooms' => 75,
                    'status' => 'active'
                ]
            ],
            [
                'name' => 'Best Western Plus Dar es Salaam',
                'description' => 'Quality accommodation with excellent facilities and friendly service.',
                'owner_id' => $owners[array_rand($owners)],
                'motel_type_id' => $motelTypes[array_rand($motelTypes)],
                'street_address' => 'Kivukoni Front, Dar es Salaam',
                'district_id' => $districts[array_rand($districts)],
                'latitude' => -6.8100,
                'longitude' => 39.2800,
                'front_image' => 'best_western.jpg',
                'created_by' => 1,
                'details' => [
                    'contact_phone' => '+255222190123',
                    'contact_email' => 'reservations@bestwestern-dar.com',
                    'total_rooms' => 110,
                    'available_rooms' => 95,
                    'status' => 'active'
                ]
            ],
            [
                'name' => 'City Garden Hotel',
                'description' => 'Boutique hotel with personalized service and comfortable accommodations.',
                'owner_id' => $owners[array_rand($owners)],
                'motel_type_id' => $motelTypes[array_rand($motelTypes)],
                'street_address' => 'Ohio Street, Dar es Salaam',
                'district_id' => $districts[array_rand($districts)],
                'latitude' => -6.8000,
                'longitude' => 39.2150,
                'front_image' => 'city_garden.jpg',
                'created_by' => 1,
                'details' => [
                    'contact_phone' => '+255222201234',
                    'contact_email' => 'info@citygardenhotel.com',
                    'total_rooms' => 60,
                    'available_rooms' => 50,
                    'status' => 'active'
                ]
            ]
        ];

        foreach ($motels as $motelData) {
            $details = $motelData['details'];
            unset($motelData['details']);
            
            $motel = Motel::create($motelData);
            
            MotelDetail::create([
                'motel_id' => $motel->id,
                'contact_phone' => $details['contact_phone'],
                'contact_email' => $details['contact_email'],
                'total_rooms' => $details['total_rooms'],
                'available_rooms' => $details['available_rooms'],
                'status' => $details['status']
            ]);
        }
    }
}