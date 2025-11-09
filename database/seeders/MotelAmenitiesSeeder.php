<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MotelAmenitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First, let's check what amenities exist in the amenities table
        $amenities = DB::table('amenities')->get();
        
        if ($amenities->isEmpty()) {
            // Create some basic amenities if none exist
            $basicAmenities = [
                ['name' => 'WiFi', 'icon' => 'wifi.png', 'createdby' => 'system'],
                ['name' => 'Pool', 'icon' => 'pool.png', 'createdby' => 'system'],
                ['name' => 'Parking', 'icon' => 'parking.png', 'createdby' => 'system'],
                ['name' => 'Restaurant', 'icon' => 'restaurant.png', 'createdby' => 'system'],
                ['name' => 'Spa', 'icon' => 'spa.png', 'createdby' => 'system'],
                ['name' => 'Gym', 'icon' => 'gym.png', 'createdby' => 'system'],
                ['name' => 'Air Conditioning', 'icon' => 'ac.png', 'createdby' => 'system'],
                ['name' => 'Room Service', 'icon' => 'room_service.png', 'createdby' => 'system'],
                ['name' => 'Laundry', 'icon' => 'laundry.png', 'createdby' => 'system'],
                ['name' => 'Concierge', 'icon' => 'concierge.png', 'createdby' => 'system'],
            ];
            
            DB::table('amenities')->insert($basicAmenities);
            $amenities = DB::table('amenities')->get();
        }
        
        // Get all motels
        $motels = DB::table('bnb_motels')->get();
        
        foreach ($motels as $motel) {
            // Add 3-5 random amenities to each motel
            $randomAmenities = $amenities->random(rand(3, 5));
            
            foreach ($randomAmenities as $amenity) {
                // Check if this amenity is already assigned to this motel
                $exists = DB::table('bnb_amenities')
                    ->where('bnb_motels_id', $motel->id)
                    ->where('amenities_id', $amenity->id)
                    ->exists();
                
                if (!$exists) {
                    DB::table('bnb_amenities')->insert([
                        'amenities_id' => $amenity->id,
                        'bnb_motels_id' => $motel->id,
                        'description' => "High-quality {$amenity->name} service available 24/7",
                        'posted_by' => 1, // Assuming admin user ID is 1
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
        
        // Add some sample images for motels
        $sampleImages = [
            'sample_hotel_1.jpg',
            'sample_hotel_2.jpg', 
            'sample_hotel_3.jpg',
            'sample_hotel_4.jpg',
            'sample_hotel_5.jpg',
        ];
        
        foreach ($motels as $motel) {
            // Add 2-4 random images to each motel
            $randomImages = collect($sampleImages)->random(rand(2, 4));
            
            foreach ($randomImages as $imagePath) {
                // Check if this image is already assigned to this motel
                $exists = DB::table('bnb_image')
                    ->where('bnb_motels_id', $motel->id)
                    ->where('filepath', $imagePath)
                    ->exists();
                
                if (!$exists) {
                    DB::table('bnb_image')->insert([
                        'bnb_motels_id' => $motel->id,
                        'filepath' => $imagePath,
                        'posted_by' => 1, // Assuming admin user ID is 1
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
        
        $this->command->info('Sample amenities and images have been added to all motels!');
    }
}