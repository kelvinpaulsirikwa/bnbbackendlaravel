<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\BnbBooking;
use App\Models\BnbTransaction;
use App\Models\BnbRoom;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function createBooking(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'customer_id' => 'required|exists:customers,id',
                'room_id' => 'required|exists:bnbrooms,id',
                'check_in_date' => 'required|date|after_or_equal:today',
                'check_out_date' => 'required|date|after:check_in_date',
                'contact_number' => 'required|string|min:10',
                'payment_method' => 'required|in:mobile_money,bank_transfer,cash,card',
                'payment_reference' => 'required|string',
                'special_requests' => 'nullable|string|max:500',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Get room details
                $room = BnbRoom::with(['motel', 'roomType'])->find($request->room_id);
            if (!$room) {
                return response()->json([
                    'success' => false,
                    'message' => 'Room not found'
                ], 404);
            }

            // Check if room is available
            if ($room->status !== 'free') {
                return response()->json([
                    'success' => false,
                    'message' => 'Room is not available for booking'
                ], 400);
            }

            // Calculate booking details
            $checkInDate = \Carbon\Carbon::parse($request->check_in_date);
            $checkOutDate = \Carbon\Carbon::parse($request->check_out_date);
            $numberOfNights = $checkInDate->diffInDays($checkOutDate);
            $pricePerNight = $room->price_per_night;
            $totalAmount = $pricePerNight * $numberOfNights;

                // Check for conflicting bookings
                $conflictingBooking = BnbBooking::where('bnb_room_id', $request->room_id)
                    ->where('status', '!=', 'cancelled')
                    ->where(function ($query) use ($checkInDate, $checkOutDate) {
                        $query->whereBetween('check_in_date', [$checkInDate, $checkOutDate])
                            ->orWhereBetween('check_out_date', [$checkInDate, $checkOutDate])
                            ->orWhere(function ($q) use ($checkInDate, $checkOutDate) {
                                $q->where('check_in_date', '<=', $checkInDate)
                                    ->where('check_out_date', '>=', $checkOutDate);
                            });
                    })
                    ->exists();

            if ($conflictingBooking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Room is not available for the selected dates'
                ], 400);
            }

            // Start database transaction
            DB::beginTransaction();

            try {
                    // Create booking
                    $booking = BnbBooking::create([
                        'customer_id' => $request->customer_id,
                        'bnb_room_id' => $request->room_id,
                        'bnb_motels_id' => $room->motelid,
                        'check_in_date' => $checkInDate,
                        'check_out_date' => $checkOutDate,
                        'number_of_nights' => $numberOfNights,
                        'price_per_night' => $pricePerNight,
                        'total_amount' => $totalAmount,
                        'contact_number' => $request->contact_number,
                        'status' => 'pending',
                        'special_requests' => $request->special_requests,
                    ]);

                    // Create per-day booking records so availability can be tracked by date
                    for ($date = $checkInDate->copy(); $date->lt($checkOutDate); $date->addDay()) {
                        \App\Models\BnbBookingDate::create([
                            'booking_id' => $booking->id,
                            'bnb_room_id' => $room->id,
                            'booked_date' => $date->format('Y-m-d'),
                            'price_per_night' => $pricePerNight,
                        ]);
                    }

                // Generate unique transaction ID
                $transactionId = 'TXN_' . strtoupper(Str::random(8)) . '_' . time();

                // Simulate payment processing (random success/failure)
                $paymentSuccess = $this->processPayment($request->payment_method, $totalAmount);

                    // Create transaction record
                    $transaction = BnbTransaction::create([
                        'booking_id' => $booking->id,
                        'transaction_id' => $transactionId,
                        'amount' => $totalAmount,
                        'payment_method' => $request->payment_method,
                        'payment_reference' => $request->payment_reference,
                        'status' => $paymentSuccess ? 'completed' : 'failed',
                        'processed_at' => $paymentSuccess ? now() : null,
                    ]);

                // Update booking status based on payment result
                $booking->update([
                    'status' => $paymentSuccess ? 'confirmed' : 'pending'
                ]);

                // Update room status if payment successful
                if ($paymentSuccess) {
                    $room->update(['status' => 'booked']);
                }

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => $paymentSuccess ? 'Booking confirmed successfully!' : 'Booking created but payment failed. Please try again.',
                    'data' => [
                        'booking' => [
                            'id' => $booking->id,
                            'booking_reference' => 'BNB_' . $booking->id,
                            'status' => $booking->status,
                                'check_in_date' => $booking->check_in_date->format('Y-m-d'),
                                'check_out_date' => $booking->check_out_date->format('Y-m-d'),
                                'number_of_nights' => $booking->number_of_nights,
                                'total_amount' => $booking->total_amount,
                            'room' => [
                                'id' => $room->id,
                                'room_number' => $room->room_number,
                                'room_type' => $room->roomType->name ?? 'Unknown Type',
                                'motel_name' => $room->motel->name ?? 'Unknown Motel',
                            ]
                        ],
                            'transaction' => [
                                'id' => $transaction->id,
                                'transaction_id' => $transaction->transaction_id,
                                'status' => $transaction->status,
                                'amount' => $transaction->amount,
                                'payment_method' => $transaction->payment_method,
                            ]
                    ]
                ], $paymentSuccess ? 200 : 402);

            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getCustomerBookings(Request $request, $customerId)
    {
        try {
            $validator = Validator::make(array_merge($request->all(), ['customer_id' => $customerId]), [
                'customer_id' => 'required|exists:customers,id',
                'page' => 'integer|min:1',
                'limit' => 'integer|min:1|max:50',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $filter = $request->get('filter');
            $debugEnabled = filter_var($request->get('debug', false), FILTER_VALIDATE_BOOLEAN);
            $debug = [];

            if ($debugEnabled) {
                $debug['input'] = [
                    'customer_id' => $customerId,
                    'page' => $page,
                    'limit' => $limit,
                    'filter' => $filter,
                ];
            }

            $query = BnbBooking::with(['customer', 'room.roomType', 'room.motel.district', 'transactions'])
                ->where('customer_id', $customerId);

            if ($debugEnabled) {
                $debug['initial_count'] = (clone $query)->count();
            }

            $today = now()->startOfDay();

            if ($filter === 'upcoming') {
                $query->whereDate('check_in_date', '>=', $today);
                if ($debugEnabled) {
                    $debug['applied_filters'][] = [
                        'type' => 'upcoming',
                        'condition' => 'check_in_date >= today',
                        'count_after' => (clone $query)->count(),
                    ];
                }
            } elseif ($filter === 'past') {
                $query->whereDate('check_out_date', '<', $today);
                if ($debugEnabled) {
                    $debug['applied_filters'][] = [
                        'type' => 'past',
                        'condition' => 'check_out_date < today',
                        'count_after' => (clone $query)->count(),
                    ];
                }
            } elseif ($filter === 'current') {
                $query->whereDate('check_in_date', '<=', $today)
                    ->whereDate('check_out_date', '>=', $today);
                if ($debugEnabled) {
                    $debug['applied_filters'][] = [
                        'type' => 'current',
                        'condition' => 'check_in_date <= today AND check_out_date >= today',
                        'count_after' => (clone $query)->count(),
                    ];
                }
            } elseif ($filter === 'active') {
                $query->whereDate('check_out_date', '>=', $today);
                if ($debugEnabled) {
                    $debug['applied_filters'][] = [
                        'type' => 'active',
                        'condition' => 'check_out_date >= today',
                        'count_after' => (clone $query)->count(),
                    ];
                }
            }

            $matchedCount = (clone $query)->count();
            if ($debugEnabled) {
                $debug['matched_count'] = $matchedCount;
            }

            $bookings = $query->orderBy('check_in_date', 'desc')
                ->paginate($limit, ['*'], 'page', $page);

            $transformedBookings = $bookings->getCollection()->map(function ($booking) {
                $room = $booking->room;
                $motel = $room?->motel;
                $customer = $booking->customer;

                return [
                    'id' => $booking->id,
                    'customer_id' => $booking->customer_id,
                    'customer' => $customer ? [
                        'id' => $customer->id,
                        'username' => $customer->username,
                        'useremail' => $customer->useremail,
                        'userimage' => $customer->userimage ?? null,
                        'phonenumber' => $customer->phonenumber ?? null,
                    ] : null,
                    'room_id' => $booking->bnb_room_id,
                    'booking_reference' => 'BNB_' . $booking->id,
                    'status' => $booking->status,
                    'check_in_date' => optional($booking->check_in_date)->format('Y-m-d'),
                    'check_out_date' => optional($booking->check_out_date)->format('Y-m-d'),
                    'number_of_nights' => $booking->number_of_nights,
                    'price_per_night' => (float) $booking->price_per_night,
                    'total_amount' => (float) $booking->total_amount,
                    'contact_number' => $booking->contact_number,
                    'special_requests' => $booking->special_requests,
                    'created_at' => optional($booking->created_at)->toIso8601String(),
                    'room' => [
                        'id' => $room?->id,
                        'room_number' => $room?->room_number,
                        'room_type' => $room?->roomType?->name,
                        'price_per_night' => $room?->price_per_night,
                    ],
                    'motel' => [
                        'id' => $motel?->id,
                        'name' => $motel?->name,
                        'address' => $motel?->street_address,
                        'district' => $motel?->district?->name,
                    ],
                    'transactions' => $booking->transactions->map(function ($transaction) {
                        return [
                            'id' => $transaction->id,
                            'transaction_id' => $transaction->transaction_id,
                            'amount' => (float) $transaction->amount,
                            'payment_method' => $transaction->payment_method,
                            'status' => $transaction->status,
                            'processed_at' => optional($transaction->processed_at)->format('Y-m-d H:i:s'),
                            'payment_reference' => $transaction->payment_reference,
                        ];
                    })->values(),
                ];
            });

            $bookings->setCollection($transformedBookings);

            if ($debugEnabled) {
                $debug['page_summary'] = [
                    'returned' => count($transformedBookings),
                    'has_more' => $bookings->hasMorePages(),
                ];
                if (count($transformedBookings) === 0) {
                    $debug['no_data_reason'] = $matchedCount === 0
                        ? 'No bookings matched the customer/filter criteria.'
                        : 'No results on this page with the current pagination settings.';
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Customer bookings retrieved successfully',
                'data' => $bookings->items(),
                'pagination' => [
                    'current_page' => $bookings->currentPage(),
                    'per_page' => $bookings->perPage(),
                    'total' => $bookings->total(),
                    'last_page' => $bookings->lastPage(),
                    'has_more' => $bookings->hasMorePages(),
                ],
                'debug' => $debugEnabled ? $debug : null,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving bookings',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get customer transactions
     */
    public function getCustomerTransactions(Request $request, $customerId)
    {
        try {
            $validator = Validator::make(
                array_merge($request->all(), ['customer_id' => $customerId]),
                [
                    'customer_id' => 'required|exists:customers,id',
                    'page' => 'integer|min:1',
                    'limit' => 'integer|min:1|max:50',
                    'status' => 'nullable|string|in:pending,completed,failed,refunded',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $page = (int) $request->get('page', 1);
            $limit = (int) $request->get('limit', 20);
            $status = $request->get('status');

            $query = BnbTransaction::with([
                'booking.customer',
                'booking.room.roomType',
                'booking.room.motel',
                'booking.room.motel.district',
            ])->whereHas('booking', function ($query) use ($customerId) {
                $query->where('customer_id', $customerId);
            });

            if ($status) {
                $query->where('status', $status);
            }

            $transactions = $query
                ->orderByDesc('processed_at')
                ->orderByDesc('created_at')
                ->paginate($limit, ['*'], 'page', $page);

            $transformedTransactions = $transactions->getCollection()->map(function ($transaction) {
                $booking = $transaction->booking;
                $room = $booking?->room;
                $motel = $room?->motel;
                $customer = $booking?->customer;

                return [
                    'id' => $transaction->id,
                    'booking_id' => $transaction->booking_id,
                    'transaction_id' => $transaction->transaction_id,
                    'amount' => (float) $transaction->amount,
                    'payment_method' => $transaction->payment_method,
                    'payment_reference' => $transaction->payment_reference,
                    'status' => $transaction->status,
                    'processed_at' => optional($transaction->processed_at)->format('Y-m-d H:i:s'),
                    'created_at' => optional($transaction->created_at)->toIso8601String(),
                    'booking' => $booking ? [
                        'id' => $booking->id,
                        'booking_reference' => 'BNB_' . $booking->id,
                        'status' => $booking->status,
                        'check_in_date' => optional($booking->check_in_date)->format('Y-m-d'),
                        'check_out_date' => optional($booking->check_out_date)->format('Y-m-d'),
                        'number_of_nights' => $booking->number_of_nights,
                        'total_amount' => (float) $booking->total_amount,
                        'customer' => $customer ? [
                            'id' => $customer->id,
                            'username' => $customer->username,
                            'useremail' => $customer->useremail,
                            'userimage' => $customer->userimage,
                            'phonenumber' => $customer->phonenumber,
                        ] : null,
                        'room' => $room ? [
                            'id' => $room->id,
                            'room_number' => $room->room_number,
                            'room_type' => $room->roomType?->name,
                            'price_per_night' => (float) $room->price_per_night,
                        ] : null,
                        'motel' => $motel ? [
                            'id' => $motel->id,
                            'name' => $motel->name,
                            'address' => $motel->street_address,
                            'district' => $motel->district?->name,
                        ] : null,
                    ] : null,
                ];
            });

            $transactions->setCollection($transformedTransactions->values());

            return response()->json([
                'success' => true,
                'message' => 'Customer transactions retrieved successfully',
                'data' => $transactions->items(),
                'pagination' => [
                    'current_page' => $transactions->currentPage(),
                    'per_page' => $transactions->perPage(),
                    'total' => $transactions->total(),
                    'last_page' => $transactions->lastPage(),
                    'has_more' => $transactions->hasMorePages(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving transactions',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    
    public function cancelBooking(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'booking_id' => 'required|exists:bnb_bookings,id',
                'customer_id' => 'required|exists:customers,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $booking = BnbBooking::where('id', $request->booking_id)
                ->where('customer_id', $request->customer_id)
                ->first();

            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking not found or access denied'
                ], 404);
            }

            if ($booking->status === 'cancelled') {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking is already cancelled'
                ], 400);
            }

            if ($booking->status === 'completed') {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot cancel completed booking'
                ], 400);
            }

            DB::beginTransaction();

            try {
                // Update booking status
                $booking->update(['status' => 'cancelled']);

                // Update room status back to free
                $booking->room->update(['status' => 'free']);

                // Update transaction status if exists
                $booking->transactions()->update(['status' => 'refunded']);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Booking cancelled successfully'
                ], 200);

            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while cancelling the booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Simulate payment processing (random success/failure)
     */
    private function processPayment($paymentMethod, $amount)
    {
        // Simulate payment processing with 80% success rate
        return rand(1, 100) <= 80;
    }
}