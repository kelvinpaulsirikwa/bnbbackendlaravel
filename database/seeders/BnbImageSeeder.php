<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BnbImage;
use App\Models\Motel;
use App\Models\BnbUser;
use Illuminate\Support\Facades\File;

class BnbImageSeeder extends Seeder
{
    public function run()
    {
        // Get Best Western Plus Dar es Salaam motel (ID: 9)
        $bestWesternMotel = Motel::where('name', 'like', '%Best Western%')->first();
        
        if (!$bestWesternMotel) {
            $this->command->error('Best Western Plus Dar es Salaam motel not found!');
            return;
        }

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

        // Create 5-8 images for Best Western Plus Dar es Salaam
        $numImages = rand(5, 8);
        $selectedImages = array_rand($imageFiles, min($numImages, count($imageFiles)));
        
        // Ensure $selectedImages is an array
        if (!is_array($selectedImages)) {
            $selectedImages = [$selectedImages];
        }
        
        foreach ($selectedImages as $imageIndex) {
            $imageFile = $imageFiles[$imageIndex];
            $filename = $imageFile->getFilename();
            
            BnbImage::create([
                'bnb_motels_id' => $bestWesternMotel->id,
                'filepath' => $filename,
                'posted_by' => $postedBy->id
            ]);
        }

        $this->command->info('Created ' . count($selectedImages) . ' images for Best Western Plus Dar es Salaam');
    }
}