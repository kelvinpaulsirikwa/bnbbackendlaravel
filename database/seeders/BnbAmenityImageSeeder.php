<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BnbAmenityImage;
use App\Models\BnbAmenity;
use App\Models\BnbUser;
use Illuminate\Support\Facades\File;

class BnbAmenityImageSeeder extends Seeder
{
    public function run()
    {
        // Get all BNB amenities
        $bnbAmenities = BnbAmenity::all();
        
        // Get a BNB user to use as posted_by
        $postedBy = BnbUser::first();
        
        if (!$postedBy) {
            $this->command->error('No BNB users found!');
            return;
        }

        // Get all image files from the sampleimageonhotel directory
        $imageDirectory = database_path('seeders/sampleimageonhotel');
        $imageFiles = File::files($imageDirectory);
        
        if (empty($imageFiles)) {
            $this->command->error('No image files found in sampleimageonhotel directory!');
            return;
        }

        // Create images for each BNB amenity
        foreach ($bnbAmenities as $bnbAmenity) {
            // Randomly select 1-3 images for each amenity
            $numImages = rand(1, 3);
            $selectedImages = array_rand($imageFiles, min($numImages, count($imageFiles)));
            
            // Ensure $selectedImages is an array
            if (!is_array($selectedImages)) {
                $selectedImages = [$selectedImages];
            }
            
            foreach ($selectedImages as $imageIndex) {
                $imageFile = $imageFiles[$imageIndex];
                $filename = $imageFile->getFilename();
                
                BnbAmenityImage::create([
                    'bnb_amenities_id' => $bnbAmenity->id,
                    'filepath' => $filename,
                    'description' => "Image showing {$bnbAmenity->amenity->name} at this motel",
                    'posted_by' => $postedBy->id
                ]);
            }
        }

        $this->command->info('Created amenity images for ' . $bnbAmenities->count() . ' BNB amenities');
    }
}