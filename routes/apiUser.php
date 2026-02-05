<?php

use App\Http\Controllers\UserApi\LoginUserByGoogleController;
use App\Http\Controllers\UserApi\RegionApiController;
use App\Http\Controllers\UserApi\DistrictApiController;
use App\Http\Controllers\UserApi\MotelTypeApiController;
use App\Http\Controllers\UserApi\MotelApiController;
use App\Http\Controllers\UserApi\MotelDetailApiController;
use App\Http\Controllers\UserApi\RoomApiController;
use App\Http\Controllers\UserApi\SearchApiController;
use App\Http\Controllers\UserApi\NearMeApiController;
use App\Http\Controllers\UserApi\BookingController;
use App\Http\Controllers\UserApi\AboutApiController;
use App\Http\Controllers\UserApi\UserChattingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| middleware group. Enjoy building your API!
|
*/

// Public route - Login only (no authentication required)
Route::post('/userlogin', [LoginUserByGoogleController::class, 'login']);

// All protected routes - require Sanctum authentication
Route::middleware('auth:sanctum')->group(function () {
    // Get authenticated user
    Route::get('/user', [LoginUserByGoogleController::class, 'me']);

    // Logout route
    Route::post('/logout', [LoginUserByGoogleController::class, 'logout']);

    // Region and District routes
    Route::get('/regions', [RegionApiController::class, 'index']);
    Route::get('/districts', [DistrictApiController::class, 'index']);
    
    // Motel type routes
    Route::get('/motel-types', [MotelTypeApiController::class, 'index']);
    
    // Motel routes
    Route::get('/motels', [MotelApiController::class, 'index']);
    Route::get('/motels/featured', [MotelApiController::class, 'featured']);

    // Motel detail routes
    Route::get('/motels/{id}/details', [MotelDetailApiController::class, 'getMotelDetails']);
    Route::get('/motels/{id}/images', [MotelDetailApiController::class, 'getMotelImages']);
    Route::get('/user/motels/{motelId}/images', [MotelDetailApiController::class, 'getMotelImagesPaging']);
    Route::get('/motels/{id}/amenities', [MotelDetailApiController::class, 'getMotelAmenities']);
    Route::get('/amenities/{bnbamenitiesid}/amenitiesimage', [MotelDetailApiController::class, 'getamenitiesimage']);
    Route::get('/motels/{id}/rules', [MotelDetailApiController::class, 'getMotelRules']);

    // Room routes
    Route::get('/motels/{id}/rooms', [RoomApiController::class, 'getMotelRooms']);
    Route::get('/motels/{id}/room-types', [RoomApiController::class, 'getMotelRoomTypes']);
    Route::get('/rooms/{id}/details', [RoomApiController::class, 'getRoomDetails']);
    Route::get('/rooms/{id}/images', [RoomApiController::class, 'getRoomImages']);
    Route::get('/rooms/{id}/items', [RoomApiController::class, 'getRoomItems']);

    // Search routes
    Route::get('/search/regions', [SearchApiController::class, 'getRegions']);
    Route::get('/search/amenities', [SearchApiController::class, 'getAmenities']);
    Route::get('/search/motels', [SearchApiController::class, 'searchMotels']);
    Route::get('/search/motels/{id}/images', [SearchApiController::class, 'getMotelImages']);
    Route::post('/search/track', [SearchApiController::class, 'trackSearch']);

    // Near me routes
    Route::get('/near-me/motels', [NearMeApiController::class, 'getNearMeMotels']);
    Route::get('/top-searched/motels', [NearMeApiController::class, 'getTopSearchedMotels']);
    Route::get('/newest/motels', [NearMeApiController::class, 'getNewestMotels']);

    // Booking routes (unified for Flutter BookingService)
    Route::post('/check-room-availability', [BookingController::class, 'checkRoomAvailability']);
    Route::post('/create-booking', [BookingController::class, 'createBooking']);
    Route::post('/create-multiple-bookings', [BookingController::class, 'createMultipleBookings']);
    Route::post('/retry-payment/{bookingId}', [BookingController::class, 'retryPayment']);
    Route::get('/booking/{bookingId}', [BookingController::class, 'getBookingDetails']);
    Route::get('/booking/customer/{customer_id}', [BookingController::class, 'getCustomerBookings']);
    Route::get('/booking/customer/{customer_id}/transactions', [BookingController::class, 'getCustomerTransactions']);
    Route::post('/booking/cancel', [BookingController::class, 'cancelBooking']);

    // About BnB routes
    Route::get('/about/statistics', [AboutApiController::class, 'getBnBStatistics']);
    Route::get('/about/amenities', [AboutApiController::class, 'getAmenities']);

    // Chat routes
    Route::get('/customer/chats', [UserChattingController::class, 'getCustomerChats']);
    Route::get('/chat/{chatId}/messages', [UserChattingController::class, 'getChatMessages']);
    Route::post('/chat/send-message', [UserChattingController::class, 'sendMessage']);
    Route::post('/chat/create-or-get', [UserChattingController::class, 'createOrGetChat']);
});
