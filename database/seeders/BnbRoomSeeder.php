<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\BnbRoom;
use App\Models\BnbRoomItem;
use App\Models\BnbRoomImage;
use App\Models\Motel;
use App\Models\RoomType;
use App\Models\BnbUser;

class BnbRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Use the Best Western Plus Dar es Salaam motel as target
        $motel = Motel::where('name', 'like', '%Best Western Plus Dar es Salaam%')
            ->orWhere('name', 'like', '%Best Western%')
            ->first();

        if (!$motel) {
            $this->command->error('Best Western Plus Dar es Salaam motel not found.');
            return;
        }

        $postedBy = BnbUser::first();
        if (!$postedBy) {
            $this->command->error('No BnbUser found to attribute created_by.');
            return;
        }

        $roomTypes = RoomType::pluck('id')->toArray();
        if (empty($roomTypes)) {
            $this->command->error('No RoomType records found.');
            return;
        }

        // Sample images directory
        $imageDirectory = database_path('seeders/sampleimageonhotel');
        $imageFiles = File::exists($imageDirectory) ? File::files($imageDirectory) : [];

        // Create a few rooms
        $roomsData = [
            [
                'room_number' => 'BW-101',
                'price_per_night' => 120.00,
                'office_price_per_night' => 100.00,
                'frontimage' => 'best_western.jpg',
            ],
            [
                'room_number' => 'BW-102',
                'price_per_night' => 140.00,
                'office_price_per_night' => 115.00,
                'frontimage' => 'best_western.jpg',
            ],
            [
                'room_number' => 'BW-201',
                'price_per_night' => 180.00,
                'office_price_per_night' => 150.00,
                'frontimage' => 'best_western.jpg',
            ],
        ];

        foreach ($roomsData as $roomData) {
            $room = BnbRoom::create([
                'motelid' => $motel->id,
                'room_number' => $roomData['room_number'],
                'room_type_id' => $roomTypes[array_rand($roomTypes)],
                'price_per_night' => $roomData['price_per_night'],
                'office_price_per_night' => $roomData['office_price_per_night'],
                'frontimage' => $roomData['frontimage'],
                'status' => 'free',
                'created_by' => $postedBy->id,
            ]);

            // Add a few default items per room
            $defaultItems = [
                ['name' => 'Air Conditioning', 'description' => 'Efficient cooling system'],
                ['name' => 'Smart TV', 'description' => '55-inch 4K TV with streaming apps'],
                ['name' => 'Mini Fridge', 'description' => 'Complimentary bottled water included'],
            ];
            foreach ($defaultItems as $item) {
                BnbRoomItem::create([
                    'bnbroomid' => $room->id,
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'created_by' => $postedBy->id,
                ]);
            }

            // Attach 2-3 random images to room if available
            if (!empty($imageFiles)) {
                $numImages = min(3, max(2, count($imageFiles) >= 2 ? 2 : 0));
                $selected = array_rand($imageFiles, $numImages);
                if (!is_array($selected)) { $selected = [$selected]; }
                foreach ($selected as $idx) {
                    $filename = $imageFiles[$idx]->getFilename();
                    BnbRoomImage::create([
                        'bnbroomid' => $room->id,
                        'imagepath' => $filename,
                        'description' => 'Room image',
                        'created_by' => $postedBy->id,
                    ]);
                }
            }
        }

        $this->command->info('Seeded rooms, items, and images for Best Western Plus Dar es Salaam.');
    }
}
