<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminApi\AdminAuthApiController;
use App\Http\Controllers\AdminApi\AdminProfileApiController;
use App\Http\Controllers\AdminApi\AmenityApiController;
use App\Http\Controllers\AdminApi\AmenityImageApiController;
use App\Http\Controllers\AdminApi\MotelImageApiController;
use App\Http\Controllers\AdminApi\MotelDetailsApiController;
use App\Http\Controllers\AdminApi\AdminRoomApiController;
use App\Http\Controllers\AdminApi\AdminChattingController;

// Admin Authentication Routes (Public)
Route::post('/admin/login', [AdminAuthApiController::class, 'login']);

// Protected Admin Routes (Require Sanctum Authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Authentication Routes
    Route::post('/admin/logout', [AdminAuthApiController::class, 'logout']);
    Route::get('/admin/me', [AdminAuthApiController::class, 'me']);

    // Admin Profile Routes
    Route::get('/admin/profile', [AdminProfileApiController::class, 'getProfile']);
    Route::put('/admin/profile', [AdminProfileApiController::class, 'updateProfile']);
    Route::post('/admin/change-password', [AdminProfileApiController::class, 'changePassword']);
    Route::get('/admin/profile/counts', [AdminProfileApiController::class, 'getProfileCounts']);

    // Admin Chat Routes
    Route::get('/admin/chats', [AdminChattingController::class, 'getChats']);
    Route::get('/admin/chat/{chatId}/messages', [AdminChattingController::class, 'getChatMessages']);
    Route::post('/admin/chat/send-message', [AdminChattingController::class, 'sendMessage']);

    // Admin Amenity Management Routes
    Route::get('/admin/motels/{motelId}/amenities', [AmenityApiController::class, 'getMotelAmenities']);
    Route::get('/admin/amenities/{id}', [AmenityApiController::class, 'getAmenity']);
    Route::post('/admin/amenities', [AmenityApiController::class, 'createAmenity']);
    Route::put('/admin/amenities/{id}', [AmenityApiController::class, 'updateAmenity']);
    Route::delete('/admin/amenities/{id}', [AmenityApiController::class, 'deleteAmenity']);
    Route::get('/admin/amenities/available', [AmenityApiController::class, 'getAvailableAmenities']);

    // Admin Amenity Image Management Routes
    Route::get('/admin/amenities/{amenityId}/images', [AmenityImageApiController::class, 'getAmenityImages']);
    Route::post('/admin/amenity-images', [AmenityImageApiController::class, 'createAmenityImage']);
    Route::put('/admin/amenity-images/{id}', [AmenityImageApiController::class, 'updateAmenityImage']);
    Route::delete('/admin/amenity-images/{id}', [AmenityImageApiController::class, 'deleteAmenityImage']);

    // Admin Motel Image Management Routes
    Route::get('/admin/motels/{motelId}/images', [MotelImageApiController::class, 'getMotelImages']);
    Route::post('/admin/motel-images', [MotelImageApiController::class, 'createMotelImage']);
    Route::put('/admin/motel-images/{id}', [MotelImageApiController::class, 'updateMotelImage']);
    Route::delete('/admin/motel-images/{id}', [MotelImageApiController::class, 'deleteMotelImage']);
    Route::get('/admin/motels/{motelId}/info', [MotelImageApiController::class, 'getMotelInfo']);

    // Admin Motel Details Management Routes
    Route::get('/admin/motels', [MotelDetailsApiController::class, 'getAllMotels']);
    Route::get('/admin/motels/{motelId}/details', [MotelDetailsApiController::class, 'getMotelDetails']);
    Route::put('/admin/motels/{motelId}/info', [MotelDetailsApiController::class, 'updateMotelInfo']);
    Route::put('/admin/motels/{motelId}/details', [MotelDetailsApiController::class, 'updateMotelDetails']);
    Route::delete('/admin/motels/{motelId}/details', [MotelDetailsApiController::class, 'deleteMotelDetails']);

    // Admin Room Management Routes
    Route::get('/admin/motels/{motelId}/rooms', [AdminRoomApiController::class, 'getMotelRooms']);
    Route::get('/admin/rooms/{roomId}/details', [AdminRoomApiController::class, 'getRoomDetails']);
    Route::put('/admin/rooms/{roomId}', [AdminRoomApiController::class, 'updateRoom']);

    // Admin Room Image Management Routes
    Route::get('/admin/rooms/{roomId}/images', [AdminRoomApiController::class, 'getRoomImages']);
    Route::post('/admin/room-images', [AdminRoomApiController::class, 'createRoomImage']);
    Route::put('/admin/room-images/{id}', [AdminRoomApiController::class, 'updateRoomImage']);
    Route::delete('/admin/room-images/{id}', [AdminRoomApiController::class, 'deleteRoomImage']);

    // Admin Room Items Management Routes
    Route::get('/admin/rooms/{roomId}/items', [AdminRoomApiController::class, 'getRoomItems']);
    Route::post('/admin/room-items', [AdminRoomApiController::class, 'createRoomItem']);
    Route::put('/admin/room-items/{id}', [AdminRoomApiController::class, 'updateRoomItem']);
    Route::delete('/admin/room-items/{id}', [AdminRoomApiController::class, 'deleteRoomItem']);
});
