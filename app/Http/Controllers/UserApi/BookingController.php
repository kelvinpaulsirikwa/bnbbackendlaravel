<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\BnbBooking;
use App\Models\BnbBookingDate;
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
                'payment_reference' => 'nullable|string|max:255',
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

            // 1. Check if room is free
            if ($room->status !== 'free') {
                return response()->json([
                    'success' => false,
                    'message' => 'Room is not available for booking'
                ], 400);
            }

            $checkInDate = \Carbon\Carbon::parse($request->check_in_date)->startOfDay();
            $checkOutDate = \Carbon\Carbon::parse($request->check_out_date)->startOfDay();
            $numberOfNights = $checkInDate->diffInDays($checkOutDate);
            $pricePerNight = $room->price_per_night;
            $totalAmount = $pricePerNight * $numberOfNights;

            // Check for conflicting bookings (per-day records)
            $conflictingBooking = BnbBookingDate::where('bnb_room_id', $request->room_id)
                ->whereBetween('booked_date', [
                    $checkInDate->format('Y-m-d'),
                    $checkOutDate->copy()->subDay()->format('Y-m-d'),
                ])
                ->exists();

            if ($conflictingBooking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Room is not available for the selected dates'
                ], 400);
            }

            DB::beginTransaction();
            try {
                // 2. Hold room (lock row so no one else can book during this request)
                BnbRoom::where('id', $room->id)->lockForUpdate()->first();

                // 3. Create booking (pending) – we need booking_id for the transaction
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

                // 4. Perform transaction (reusable: simulate + fill transaction); then make booking and room status
                $result = $this->simulateAndRecordTransaction(
                    $request->contact_number,
                    (float) $totalAmount,
                    $booking->id,
                    $request->payment_method,
                    $request->payment_reference
                );
                $paymentSuccess = $result['success'];
                $transaction = $result['transaction'];

                // 5. If transaction successful: confirm booking, create per-day records (trigger updates room status)
                if ($paymentSuccess) {
                    $booking->update(['status' => 'confirmed']);
                    for ($date = $checkInDate->copy(); $date->lt($checkOutDate); $date->addDay()) {
                        BnbBookingDate::create([
                            'booking_id' => $booking->id,
                            'bnb_room_id' => $room->id,
                            'booked_date' => $date->format('Y-m-d'),
                            'price_per_night' => $pricePerNight,
                        ]);
                    }
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

    /**
     * Create multiple bookings (one per date) for "Pick Dates" mode.
     * Flutter: POST /create-multiple-bookings
     * Body: room_id, customer_id, selected_dates (array of Y-m-d), contact_number, payment_method, payment_reference?, special_requests?
     */
    public function createMultipleBookings(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'room_id' => 'required|exists:bnbrooms,id',
                'customer_id' => 'required|exists:customers,id',
                'selected_dates' => 'required|array|min:1',
                'selected_dates.*' => 'required|date|after_or_equal:today',
                'contact_number' => 'required|string|min:10',
                'payment_method' => 'required|in:mobile_money,bank_transfer,cash,card',
                'payment_reference' => 'nullable|string|max:255',
                'special_requests' => 'nullable|string|max:500',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $room = BnbRoom::with(['motel', 'roomType'])->find($request->room_id);
            if (!$room) {
                return response()->json([
                    'success' => false,
                    'message' => 'Room not found',
                ], 404);
            }

            $selectedDates = collect($request->selected_dates)
                ->map(fn ($d) => \Carbon\Carbon::parse($d)->startOfDay()->format('Y-m-d'))
                ->unique()
                ->sort()
                ->values()
                ->all();

            if (empty($selectedDates)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No valid dates selected.',
                ], 422);
            }

            // 1. Check if room is available for all selected dates
            $alreadyBooked = BnbBookingDate::where('bnb_room_id', $room->id)
                ->whereIn('booked_date', $selectedDates)
                ->pluck('booked_date')
                ->map(fn ($d) => \Carbon\Carbon::parse($d)->format('Y-m-d'))
                ->all();

            if (!empty($alreadyBooked)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Room is not available for some selected dates.',
                    'booked_dates' => array_values($alreadyBooked),
                ], 400);
            }

            $pricePerNight = (float) $room->price_per_night;
            $totalAmount = $pricePerNight * count($selectedDates);

            DB::beginTransaction();
            try {
                // 2. Create all bookings (pending) so we have booking ids; then proceed with one transaction
                $bookings = [];
                foreach ($selectedDates as $dateStr) {
                    $checkIn = \Carbon\Carbon::parse($dateStr)->startOfDay();
                    $checkOut = $checkIn->copy()->addDay();

                    $booking = BnbBooking::create([
                        'customer_id' => $request->customer_id,
                        'bnb_room_id' => $room->id,
                        'bnb_motels_id' => $room->motelid,
                        'check_in_date' => $checkIn,
                        'check_out_date' => $checkOut,
                        'number_of_nights' => 1,
                        'price_per_night' => $pricePerNight,
                        'total_amount' => $pricePerNight,
                        'contact_number' => $request->contact_number,
                        'status' => 'pending',
                        'special_requests' => $request->special_requests,
                    ]);
                    $bookings[] = $booking;
                }

                // 3. Perform transaction (reusable: simulate + fill transaction) for total amount
                $result = $this->simulateAndRecordTransaction(
                    $request->contact_number,
                    $totalAmount,
                    $bookings[0]->id,
                    $request->payment_method,
                    $request->payment_reference
                );
                $paymentSuccess = $result['success'];
                $transaction = $result['transaction'];

                // 4. If transaction successful: confirm all bookings and create booking_dates for each date (room status via trigger)
                if ($paymentSuccess) {
                    foreach ($bookings as $b) {
                        $b->update(['status' => 'confirmed']);
                    }
                    foreach ($bookings as $booking) {
                        $checkIn = \Carbon\Carbon::parse($booking->check_in_date)->startOfDay();
                        BnbBookingDate::create([
                            'booking_id' => $booking->id,
                            'bnb_room_id' => $room->id,
                            'booked_date' => $checkIn->format('Y-m-d'),
                            'price_per_night' => $pricePerNight,
                        ]);
                    }
                }

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => $paymentSuccess
                        ? 'Bookings created successfully.'
                        : 'Bookings created but payment failed. Please try again.',
                    'data' => [
                        'bookings' => collect($bookings)->map(fn ($b) => [
                            'id' => $b->id,
                            'booking_reference' => 'BNB_' . $b->id,
                            'check_in_date' => \Carbon\Carbon::parse($b->check_in_date)->format('Y-m-d'),
                            'check_out_date' => \Carbon\Carbon::parse($b->check_out_date)->format('Y-m-d'),
                            'status' => $b->fresh()->status,
                        ])->all(),
                        'transaction' => [
                            'id' => $transaction->id,
                            'transaction_id' => $transaction->transaction_id,
                            'amount' => (float) $transaction->amount,
                            'payment_method' => $transaction->payment_method,
                            'status' => $transaction->status,
                        ],
                        'room' => [
                            'id' => $room->id,
                            'room_number' => $room->room_number,
                            'room_type' => $room->roomType->name ?? null,
                            'motel_name' => $room->motel->name ?? null,
                        ],
                    ],
                ], $paymentSuccess ? 200 : 402);
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating bookings',
                'error' => $e->getMessage(),
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
                        'image' => $motel?->front_image ? url('storage/' . $motel->front_image) : null,
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
                            'image' => $motel->front_image ? url('storage/' . $motel->front_image) : null,
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

                // Remove per-day booking records for this booking
                $room = $booking->room;
                if ($room) {
                    $booking->bookingDates()->delete();

                    // Recalculate room status based on remaining future booking dates
                    $hasFutureBookings = $room->bookingDates()
                        ->where('booked_date', '>=', now()->toDateString())
                        ->exists();

                    $room->update(['status' => $hasFutureBookings ? 'booked' : 'free']);
                }

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
     * Check room availability for a date range (Flutter: POST /check-room-availability).
     * Returns each date in the range with status "available" or "booked".
     */
    public function checkRoomAvailability(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'room_id' => 'required|integer|exists:bnbrooms,id',
                'check_in_date' => 'required|date|after_or_equal:today',
                'check_out_date' => 'required|date|after:check_in_date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $roomId = (int) $request->room_id;
            $checkInDate = \Carbon\Carbon::parse($request->check_in_date)->startOfDay();
            $checkOutDate = \Carbon\Carbon::parse($request->check_out_date)->startOfDay();

            $room = BnbRoom::find($roomId);
            if (!$room) {
                return response()->json([
                    'success' => false,
                    'message' => 'Room not found',
                ], 404);
            }

            // Get all booked dates for this room in the range (nights: check_in inclusive, check_out exclusive)
            $bookedDateStrings = BnbBookingDate::where('bnb_room_id', $roomId)
                ->whereBetween('booked_date', [
                    $checkInDate->format('Y-m-d'),
                    $checkOutDate->copy()->subDay()->format('Y-m-d'),
                ])
                ->pluck('booked_date')
                ->map(fn ($d) => \Carbon\Carbon::parse($d)->format('Y-m-d'))
                ->unique()
                ->values()
                ->all();

            $dates = [];
            for ($date = $checkInDate->copy(); $date->lt($checkOutDate); $date->addDay()) {
                $dateStr = $date->format('Y-m-d');
                $status = in_array($dateStr, $bookedDateStrings) ? 'booked' : 'available';
                $dates[] = [
                    'date' => $dateStr,
                    'status' => $status,
                    'message' => $status === 'booked' ? 'Booked on this date' : 'Available',
                ];
            }

            $allAvailable = !empty($dates) && collect($dates)->every(fn ($d) => $d['status'] === 'available');

            return response()->json([
                'success' => true,
                'available' => $allAvailable,
                'message' => $allAvailable
                    ? 'Room is available for all selected dates'
                    : 'Some dates are already booked',
                'data' => [
                    'room_id' => $roomId,
                    'check_in_date' => $checkInDate->format('Y-m-d'),
                    'check_out_date' => $checkOutDate->format('Y-m-d'),
                    'dates' => $dates,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to check room availability: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get a single booking by ID (Flutter: GET /booking/{bookingId})
     */
    public function getBookingDetails(Request $request, $bookingId)
    {
        try {
            $booking = BnbBooking::with([
                'customer',
                'room.roomType',
                'room.motel.district',
                'transactions',
            ])->find($bookingId);

            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking not found',
                ], 404);
            }

            $room = $booking->room;
            $motel = $room?->motel;
            $customer = $booking->customer;

            $data = [
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
                    'price_per_night' => $room ? (float) $room->price_per_night : null,
                ],
                'motel' => [
                    'id' => $motel?->id,
                    'name' => $motel?->name,
                    'address' => $motel?->street_address,
                    'district' => $motel?->district?->name,
                    'image' => $motel?->front_image ? url('storage/' . $motel->front_image) : null,
                ],
                'transactions' => $booking->transactions->map(function ($t) {
                    return [
                        'id' => $t->id,
                        'transaction_id' => $t->transaction_id,
                        'amount' => (float) $t->amount,
                        'payment_method' => $t->payment_method,
                        'status' => $t->status,
                        'processed_at' => optional($t->processed_at)->format('Y-m-d H:i:s'),
                        'payment_reference' => $t->payment_reference,
                    ];
                })->values(),
            ];

            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'Booking details retrieved successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get booking details: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Retry payment for a failed/pending booking (Flutter: POST /retry-payment/{bookingId})
     */
    public function retryPayment(Request $request, $bookingId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'payment_method' => 'required|in:mobile_money,bank_transfer,cash,card',
                'payment_reference' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $booking = BnbBooking::with(['room'])->find($bookingId);
            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking not found',
                ], 404);
            }

            if ($booking->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only pending bookings can be retried',
                ], 400);
            }

            $room = $booking->room;
            if (!$room) {
                return response()->json([
                    'success' => false,
                    'message' => 'Room not found for this booking',
                ], 404);
            }

            DB::beginTransaction();
            try {
                $totalAmount = (float) $booking->total_amount;
                $result = $this->simulateAndRecordTransaction(
                    $booking->contact_number,
                    $totalAmount,
                    $booking->id,
                    $request->payment_method,
                    $request->payment_reference
                );
                $paymentSuccess = $result['success'];

                $booking->update(['status' => $paymentSuccess ? 'confirmed' : 'pending']);

                if ($paymentSuccess) {
                    $checkIn = \Carbon\Carbon::parse($booking->check_in_date)->startOfDay();
                    $checkOut = \Carbon\Carbon::parse($booking->check_out_date)->startOfDay();
                    $pricePerNight = (float) $booking->price_per_night;
                    for ($date = $checkIn->copy(); $date->lt($checkOut); $date->addDay()) {
                        BnbBookingDate::create([
                            'booking_id' => $booking->id,
                            'bnb_room_id' => $room->id,
                            'booked_date' => $date->format('Y-m-d'),
                            'price_per_night' => $pricePerNight,
                        ]);
                    }
                }

                DB::commit();

                return response()->json([
                    'success' => $paymentSuccess,
                    'message' => $paymentSuccess ? 'Payment completed successfully' : 'Payment failed. Please try again.',
                    'data' => [
                        'booking_id' => $booking->id,
                        'status' => $booking->fresh()->status,
                    ],
                ], $paymentSuccess ? 200 : 402);
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrying payment: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Reusable: simulate payment and fill transaction record.
     * Uses contact number and amount for simulation only; creates BnbTransaction and returns success.
     *
     * @return array{success: bool, transaction: BnbTransaction}
     */
    private function simulateAndRecordTransaction(
        string $contactNumber,
        float $amount,
        int $bookingId,
        string $paymentMethod,
        ?string $paymentReference = null
    ): array {
        $success = $this->processPayment($paymentMethod, $amount);
        $transactionId = 'TXN_' . strtoupper(Str::random(8)) . '_' . time();

        $transaction = BnbTransaction::create([
            'booking_id' => $bookingId,
            'transaction_id' => $transactionId,
            'amount' => $amount,
            'payment_method' => $this->normalizePaymentMethod($paymentMethod),
            'payment_reference' => $paymentReference,
            'status' => $success ? 'completed' : 'failed',
            'processed_at' => $success ? now() : null,
        ]);

        return ['success' => $success, 'transaction' => $transaction];
    }

    /**
     * Map Flutter payment_method to DB enum (mobile, bank_card, cash)
     */
    private function normalizePaymentMethod(string $method): string
    {
        return match (strtolower($method)) {
            'mobile_money' => 'mobile',
            'bank_transfer', 'card' => 'bank_card',
            'cash' => 'cash',
            default => 'cash',
        };
    }

    /**
     * Simulate payment processing (random success/failure)
     */
    private function processPayment($paymentMethod, $amount): bool
    {
        // Simulate payment processing with 80% success rate
        return rand(1, 100) <= 80;
    }
}