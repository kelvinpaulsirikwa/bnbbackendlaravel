<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AmenitySeeder extends Seeder
{
    public function run()
    {
        // Get all image files from the sampleimageonhotel directory
        $imageDirectory = database_path('seeders/sampleimageonhotel');
        $imageFiles = File::files($imageDirectory);
        
        // Define common hotel amenities with their corresponding images
        $amenities = [
            [
                'name' => 'Free WiFi',
                'icon' => 'bill_sing-removebg-preview.png',
                'createdby' => 'system'
            ],
            [
                'name' => 'Swimming Pool',
                'icon' => 'ChatGPT Image Oct 16, 2025, 10_03_18 AM.png',
                'createdby' => 'system'
            ],
            [
                'name' => 'Fitness Center',
                'icon' => 'ChatGPT Image Oct 16, 2025, 10_06_02 AM.png',
                'createdby' => 'system'
            ],
            [
                'name' => 'Restaurant',
                'icon' => 'ChatGPT Image Sep 25, 2025, 04_05_36 PM.png',
                'createdby' => 'system'
            ],
            [
                'name' => 'Bar/Lounge',
                'icon' => 'ChatGPT Image Sep 25, 2025, 04_10_37 PM.png',
                'createdby' => 'system'
            ],
            [
                'name' => 'Spa Services',
                'icon' => 'ChatGPT Image Sep 25, 2025, 04_16_58 PM.png',
                'createdby' => 'system'
            ],
            [
                'name' => 'Business Center',
                'icon' => 'logo-removebg-preview (1).png',
                'createdby' => 'system'
            ],
            [
                'name' => 'Conference Room',
                'icon' => 'logo-removebg-preview.png',
                'createdby' => 'system'
            ],
            [
                'name' => 'Room Service',
                'icon' => 'Proudly Presented to (1).png',
                'createdby' => 'system'
            ],
            [
                'name' => 'Laundry Service',
                'icon' => 'Proudly Presented to.png',
                'createdby' => 'system'
            ],
            [
                'name' => 'Parking',
                'icon' => 'WhatsApp Image 2023-02-09 at 08.42.55 (1).jpeg',
                'createdby' => 'system'
            ]
        ];

        // Insert amenities into database
        foreach ($amenities as $amenity) {
            // Check if the image file exists
            $imagePath = $imageDirectory . '/' . $amenity['icon'];
            if (File::exists($imagePath)) {
                DB::table('amenities')->insert([
                    'name' => $amenity['name'],
                    'icon' => $amenity['icon'],
                    'createdby' => $amenity['createdby'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
