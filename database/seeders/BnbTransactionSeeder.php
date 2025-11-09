<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\BnbBooking;
use App\Models\BnbTransaction;
use Carbon\Carbon;

class BnbTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $targetCustomers = [1, 14];
        $statuses = ['completed', 'pending', 'failed', 'refunded'];
        $methods = ['mobile', 'bank_card', 'cash'];

        foreach ($targetCustomers as $customerId) {
            $bookings = BnbBooking::where('customer_id', $customerId)
                ->orderBy('check_in_date', 'desc')
                ->get();

            if ($bookings->isEmpty()) {
                if ($this->command) {
                    $this->command->warn("No bookings found for customer ID {$customerId}. Skipping transactions.");
                }
                continue;
            }

            $transactionsPerCustomer = 5;
            for ($i = 0; $i < $transactionsPerCustomer; $i++) {
                $booking = $bookings[$i % $bookings->count()];
                $status = $statuses[$i % count($statuses)];
                $method = $methods[$i % count($methods)];

                $amount = $booking->total_amount > 0
                    ? $booking->total_amount
                    : ($booking->price_per_night ?: 100) * max($booking->number_of_nights ?: 1, 1);

                $processedAt = in_array($status, ['completed', 'refunded'], true)
                    ? Carbon::now()->subDays(random_int(1, 60))->setTime(random_int(8, 20), random_int(0, 59))
                    : null;

                BnbTransaction::create([
                    'booking_id' => $booking->id,
                    'transaction_id' => 'TX-' . Str::upper(Str::random(10)),
                    'amount' => $amount,
                    'payment_method' => $method,
                    'payment_reference' => strtoupper(Str::random(12)),
                    'status' => $status,
                    'payment_details' => json_encode([
                        'channel' => $method,
                        'note' => 'Seeded transaction data',
                    ]),
                    'gateway_response' => json_encode([
                        'code' => $status === 'failed' ? 'ERR' . random_int(100, 999) : '00',
                        'message' => $status === 'failed' ? 'Payment failed during processing.' : 'Approved',
                    ]),
                    'processed_at' => $processedAt,
                    'created_at' => Carbon::now()->subDays(random_int(10, 90))->setTime(random_int(8, 20), random_int(0, 59)),
                    'updated_at' => Carbon::now(),
                ]);
            }

            if ($this->command) {
                $this->command->info("Seeded {$transactionsPerCustomer} transactions for customer ID {$customerId}.");
            }
        }
    }
}


