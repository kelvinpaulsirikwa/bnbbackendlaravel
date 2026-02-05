<?php

namespace App\Http\Controllers;

use App\Models\BnbBooking;
use App\Models\BnbRoom;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BookingAndTransactionApiController extends Controller
{
    public function createBookingAndProcessPayment(Request $request)
    {
        try {
            // Validate input data
            $rules = [
                'room_id' => 'required|integer|min:1',
                'customer_id' => 'required|integer|min:1',
                'check_in_date' => 'required|date|after_or_equal:today',
                'check_out_date' => 'required|date|after:check_in_date',
                'contact_number' => 'required|string|min:10|max:15', 
            ];

         
            $validator = Validator::make($request->all(), $rules, [
                'room_id.required' => 'Room ID is required',
                'room_id.integer' => 'Room ID must be a valid number',
                'customer_id.required' => 'Customer ID is required',
                'customer_id.integer' => 'Customer ID must be a valid number',
                'check_in_date.required' => 'Check-in date is required',
                'check_in_date.date' => 'Check-in date must be a valid date',
                'check_in_date.after_or_equal' => 'Check-in date must be today or in the future',
                'check_out_date.required' => 'Check-out date is required',
                'check_out_date.date' => 'Check-out date must be a valid date',
                'check_out_date.after' => 'Check-out date must be after check-in date',
                'contact_number.required' => 'Contact number is required',
                'contact_number.min' => 'Contact number must be at least 10 characters',
                'payment_method.required' => 'Payment method is required',
                'payment_method.in' => 'Payment method must be mobile_money, cash, or card',
                ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $roomId = $request->input('room_id');
            $customerId = $request->input('customer_id');
            $checkInDate = Carbon::parse($request->input('check_in_date'));
            $checkOutDate = Carbon::parse($request->input('check_out_date'));
            $contactNumber = $request->input('contact_number');

            // Validate contact number format (Tanzania phone number)
            $contactNumberValidation = $this->validateTanzaniaPhoneNumber($contactNumber);
            if (!$contactNumberValidation['valid']) {
                return response()->json([
                    'success' => false,
                    'message' => $contactNumberValidation['message'],
                ], 422);
            }

            // Check if room exists
            $room = BnbRoom::find($roomId);
            if (!$room) {
                return response()->json([
                    'success' => false,
                    'message' => 'Room not found',
                ], 404);
            }

            // Check if customer exists
            $customer = Customer::find($customerId);
            if (!$customer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Customer not found',
                ], 404);
            }

            // Check room availability for the selected dates
            $isAvailable = $this->isRoomAvailable($roomId, $checkInDate, $checkOutDate);
            if (!$isAvailable) {
                return response()->json([
                    'success' => false,
                    'message' => 'Room is not available for the selected dates',
                ], 409);
            }

            // Calculate booking details
            $numberOfNights = $checkInDate->diffInDays($checkOutDate);
            $pricePerNight = $room->price_per_night ?? 0;
            $totalAmount = $pricePerNight * $numberOfNights;

            // All validations passed - return success response (without saving to database)
            return response()->json([
                'success' => true,
                'message' => 'Booking validated successfully',
                'data' => [
                    'booking' => [
                        'room_id' => $roomId,
                        'customer_id' => $customerId,
                        'check_in_date' => $checkInDate->format('Y-m-d'),
                        'check_out_date' => $checkOutDate->format('Y-m-d'),
                        'number_of_nights' => $numberOfNights,
                        'price_per_night' => $pricePerNight,
                        'total_amount' => $totalAmount,
                        'contact_number' => $contactNumber,
                        'special_requests' => $request->input('special_requests'),
                    ],
                    'transaction' => [
                        'payment_method' => $request->input('payment_method'),
                        'payment_reference' => $request->input('payment_reference'),
                        'status' => 'validated', // Not saved, just validated
                    ],
                ],
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to validate booking: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Check room availability for given dates
     */
    private function isRoomAvailable($roomId, $checkInDate, $checkOutDate)
    {
        // Check if there are any existing bookings that overlap with the requested dates
        $conflictingBookings = BnbBooking::where('bnb_room_id', $roomId)
            ->where('status', '!=', 'cancelled') // Exclude cancelled bookings
            ->where(function ($query) use ($checkInDate, $checkOutDate) {
                $query->whereBetween('check_in_date', [$checkInDate, $checkOutDate->copy()->subDay()])
                    ->orWhereBetween('check_out_date', [$checkInDate->copy()->addDay(), $checkOutDate])
                    ->orWhere(function ($q) use ($checkInDate, $checkOutDate) {
                        $q->where('check_in_date', '<=', $checkInDate)
                          ->where('check_out_date', '>=', $checkOutDate);
                    });
            })
            ->exists();

        return !$conflictingBookings;
    }

    /**
     * Validate Tanzania phone number format
     */
    private function validateTanzaniaPhoneNumber($phoneNumber)
    {
        // Remove any spaces or special characters except +
        $cleanNumber = preg_replace('/[^\d+]/', '', $phoneNumber);

        // Check if it starts with + and country code
        if (strpos($cleanNumber, '+') === 0) {
            // For international format (+255...)
            if (strlen($cleanNumber) < 12 || strlen($cleanNumber) > 13) {
                return [
                    'valid' => false,
                    'message' => 'Invalid phone number format. International format should be +255XXXXXXXXX',
                ];
            }
            if (!str_starts_with($cleanNumber, '+255')) {
                return [
                    'valid' => false,
                    'message' => 'Please use Tanzania phone number (+255...)',
                ];
            }
        } elseif (strpos($cleanNumber, '0') === 0) {
            // For local format (0...)
            if (strlen($cleanNumber) != 10) {
                return [
                    'valid' => false,
                    'message' => 'Phone number must be 10 digits (0XXXXXXXXX)',
                ];
            }
        } elseif (strpos($cleanNumber, '255') === 0) {
            // For format without + (255...)
            if (strlen($cleanNumber) != 12) {
                return [
                    'valid' => false,
                    'message' => 'Invalid phone number format',
                ];
            }
        } else {
            return [
                'valid' => false,
                'message' => 'Phone number must start with 0, 255, or +255',
            ];
        }

        // Validate Tanzania mobile prefixes
        $prefix = '';
        if (str_starts_with($cleanNumber, '+255')) {
            $prefix = substr($cleanNumber, 4, 2);
        } elseif (str_starts_with($cleanNumber, '255')) {
            $prefix = substr($cleanNumber, 3, 2);
        } else {
            $prefix = substr($cleanNumber, 1, 2);
        }

        $validPrefixes = ['61', '62', '65', '67', '68', '69', '71', '72', '73', '74', '75', '76', '77', '78'];
        if (!in_array($prefix, $validPrefixes)) {
            return [
                'valid' => false,
                'message' => 'Invalid Tanzania mobile number prefix',
            ];
        }

        return ['valid' => true];
    }

    public function checkRoomAvailability(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'room_id' => 'required|integer|min:1',
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

            $roomId = $request->input('room_id');
            $checkInDate = Carbon::parse($request->input('check_in_date'));
            $checkOutDate = Carbon::parse($request->input('check_out_date'));

            // Check if room exists
            $room = BnbRoom::find($roomId);
            if (!$room) {
                return response()->json([
                    'success' => false,
                    'message' => 'Room not found',
                ], 404);
            }

            $isAvailable = $this->isRoomAvailable($roomId, $checkInDate, $checkOutDate);

            return response()->json([
                'success' => true,
                'available' => $isAvailable,
                'message' => $isAvailable ? 'Room is available' : 'Room is not available for the selected dates',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to check room availability: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Retry payment (validation only)
     */
    public function retryPayment(Request $request, $bookingId)
    {
        try {
            // Check if booking exists first
            $booking = BnbBooking::find($bookingId);
            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking not found',
                ], 404);
            }

            // Validate input data with conditional rules
            $rules = [
                'payment_method' => 'required|string|in:mobile_money,cash,card',
                'payment_reference' => 'nullable|string|max:255',
            ];

            // Add conditional validation for payment_reference
            if ($request->input('payment_method') === 'mobile_money') {
                $rules['payment_reference'] = 'required|string|min:1|max:255';
            }

            $validator = Validator::make($request->all(), $rules, [
                'payment_method.required' => 'Payment method is required',
                'payment_method.in' => 'Payment method must be mobile_money, cash, or card',
                'payment_reference.required' => 'Payment reference is required for mobile money payment',
                'payment_reference.min' => 'Payment reference cannot be empty',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            return response()->json([
                'success' => true,
                'message' => 'Payment validation successful',
                'data' => [
                    'booking' => $booking,
                    'transaction' => [
                        'payment_method' => $request->input('payment_method'),
                        'payment_reference' => $request->input('payment_reference'),
                        'status' => 'validated',
                    ],
                ],
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to validate payment: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getBookingDetails($bookingId)
    {
        try {
            $booking = BnbBooking::with(['customer', 'room', 'transactions'])
                ->find($bookingId);

            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $booking,
                'message' => 'Booking details retrieved successfully',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get booking details: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function cancelBooking(Request $request, $bookingId)
    {
        try {
            $booking = BnbBooking::find($bookingId);

            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking not found',
                ], 404);
            }

            // Validation only - check if booking can be cancelled
            if ($booking->status === 'cancelled') {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking is already cancelled',
                ], 409);
            }

            // Check if check-in date has passed
            if (Carbon::parse($booking->check_in_date)->isPast()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot cancel booking after check-in date',
                ], 409);
            }

            return response()->json([
                'success' => true,
                'message' => 'Booking can be cancelled (validation only)',
                'data' => [
                    'booking_id' => $bookingId,
                    'status' => 'validated_for_cancellation',
                ],
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to validate booking cancellation: ' . $e->getMessage(),
            ], 500);
        }
    }
}