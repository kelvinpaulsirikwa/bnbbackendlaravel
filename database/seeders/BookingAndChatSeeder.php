<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\Motel;
use App\Models\BnbRoom;
use App\Models\BnbBooking;
use App\Models\BnbChat;
use App\Models\BnbChatMessage;
use App\Models\BnbUser;
use Carbon\Carbon;

class BookingAndChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Find or create customer ID 1 (Kelvin)
        $customer = Customer::find(1);
        
        if (!$customer) {
            // Check if customers table is empty
            $maxId = Customer::max('id');
            
            if (!$maxId || $maxId < 1) {
                // Table is empty or no ID >= 1, we can insert with ID 1
                DB::table('customers')->insert([
                    'id' => 1,
                    'username' => 'Kelvin',
                    'useremail' => 'kelvin@example.com',
                    'phonenumber' => '+255712345678',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $customer = Customer::find(1);
            } else {
                // Create normally (will get next auto-increment ID)
                $customer = Customer::create([
                    'username' => 'Kelvin',
                    'useremail' => 'kelvin@example.com',
                    'phonenumber' => '+255712345678',
                ]);
            }
            $this->command->info("Created customer: {$customer->username} (ID: {$customer->id})");
        } else {
            $this->command->info("Found existing customer: {$customer->username} (ID: {$customer->id})");
        }

        // Get 3 different motels (take first 3 available)
        $motels = Motel::limit(3)->get();

        if ($motels->count() < 3) {
            $this->command->error('Not enough motels found. Please seed motels first.');
            return;
        }

        // Get a BNB user (hotel staff) for chat messages
        $bnbUser = BnbUser::where('role', 'bnbowner')->first() 
            ?? BnbUser::first();

        if (!$bnbUser) {
            $this->command->error('No BNB users found. Please seed BNB users first.');
            return;
        }

        $this->command->info("Creating bookings and chats for customer: {$customer->username} (ID: {$customer->id})");

        foreach ($motels as $index => $motel) {
            // Get or create a room for this motel
            $room = BnbRoom::where('motelid', $motel->id)->first();

            if (!$room) {
                // Create a room if it doesn't exist
                $roomType = \App\Models\RoomType::first();
                $postedBy = BnbUser::first();

                $room = BnbRoom::create([
                    'motelid' => $motel->id,
                    'room_number' => "RM-" . str_pad($motel->id, 3, '0', STR_PAD_LEFT) . "-101",
                    'room_type_id' => $roomType ? $roomType->id : 1,
                    'price_per_night' => 100.00 + ($index * 20),
                    'office_price_per_night' => 80.00 + ($index * 15),
                    'status' => 'free',
                    'created_by' => $postedBy ? $postedBy->id : 1,
                ]);
            }

            // Calculate dates for booking
            $checkInDate = Carbon::now()->addDays($index * 7 + 3); // Different dates for each booking
            $checkOutDate = $checkInDate->copy()->addDays(2); // 2 nights
            $numberOfNights = $checkInDate->diffInDays($checkOutDate);
            $pricePerNight = $room->price_per_night;
            $totalAmount = $pricePerNight * $numberOfNights;

            // Create booking
            $booking = BnbBooking::create([
                'customer_id' => $customer->id,
                'bnb_room_id' => $room->id,
                'check_in_date' => $checkInDate,
                'check_out_date' => $checkOutDate,
                'number_of_nights' => $numberOfNights,
                'price_per_night' => $pricePerNight,
                'total_amount' => $totalAmount,
                'contact_number' => $customer->phonenumber ?? '+255712345678',
                'status' => 'confirmed',
                'special_requests' => "Booking for {$motel->name} - Room {$room->room_number}",
            ]);

            $this->command->info("  ✓ Created booking #{$booking->id} for {$motel->name}");

            // Create chat for this booking
            $chat = BnbChat::create([
                'booking_id' => $booking->id,
                'motel_id' => $motel->id,
                'customer_id' => $customer->id,
                'started_by' => 'customer',
                'status' => 'active',
            ]);

            $this->command->info("    ✓ Created chat #{$chat->id}");

            // Create sample chat messages
            $messages = [
                [
                    'sender_type' => 'customer',
                    'sender_id' => $customer->id,
                    'message' => "Hello! I have a booking for {$motel->name}. Can you confirm my check-in time?",
                ],
                [
                    'sender_type' => 'bnbuser',
                    'sender_id' => $bnbUser->id,
                    'message' => "Hello! Thank you for your booking. Check-in time is from 2:00 PM. We're looking forward to welcoming you!",
                ],
                [
                    'sender_type' => 'customer',
                    'sender_id' => $customer->id,
                    'message' => "Great, thank you! I should arrive around 3 PM. Is parking available?",
                ],
                [
                    'sender_type' => 'bnbuser',
                    'sender_id' => $bnbUser->id,
                    'message' => "Yes, we have parking available for our guests. It's complimentary. Safe travels!",
                ],
            ];

            foreach ($messages as $messageIndex => $messageData) {
                $chatMessage = BnbChatMessage::create([
                    'chat_id' => $chat->id,
                    'sender_type' => $messageData['sender_type'],
                    'sender_id' => $messageData['sender_id'],
                    'message' => $messageData['message'],
                    'read_status' => $messageIndex < 2 ? 'read' : 'unread', // First 2 messages read
                    'created_at' => Carbon::now()->subMinutes(count($messages) - $messageIndex),
                ]);
            }

            $this->command->info("    ✓ Created " . count($messages) . " chat messages");
        }

        $this->command->info("\n✓ Successfully created 3 bookings and chats for {$customer->username}!");
    }
}
