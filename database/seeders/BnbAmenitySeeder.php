<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BnbAmenity;
use App\Models\Amenity;
use App\Models\Motel;
use App\Models\BnbUser;

class BnbAmenitySeeder extends Seeder
{
    public function run()
    {
        // Get Best Western Plus Dar es Salaam motel (ID: 9)
        $bestWesternMotel = Motel::where('name', 'like', '%Best Western%')->first();
        
        if (!$bestWesternMotel) {
            $this->command->error('Best Western Plus Dar es Salaam motel not found!');
            return;
        }

        // Get all amenities
        $amenities = Amenity::all();
        
        // Get a BNB user to use as posted_by
        $postedBy = BnbUser::first();
        
        if (!$postedBy) {
            $this->command->error('No BNB users found!');
            return;
        }

        // Create BNB amenities for Best Western Plus Dar es Salaam
        foreach ($amenities as $amenity) {
            BnbAmenity::create([
                'amenities_id' => $amenity->id,
                'bnb_motels_id' => $bestWesternMotel->id,
                'description' => "This motel offers {$amenity->name} for guest convenience and comfort.",
                'posted_by' => $postedBy->id
            ]);
        }

        $this->command->info('Created ' . $amenities->count() . ' BNB amenities for Best Western Plus Dar es Salaam');
    }
}