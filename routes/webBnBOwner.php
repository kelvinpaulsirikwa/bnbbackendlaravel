<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BnBOwner\DashboardController;
use App\Http\Controllers\BnBOwner\HotelManagementController;
use App\Http\Controllers\BnBOwner\HotelImageController;
use App\Http\Controllers\BnBOwner\AmenityManagementController;
use App\Http\Controllers\BnBOwner\RoomManagementController;
use App\Http\Controllers\BnBOwner\RoomItemController;
use App\Http\Controllers\BnBOwner\RoomImageController;
use App\Http\Controllers\BnBOwner\StaffManagementController;
use App\Http\Controllers\BnBOwner\ChatController;
use App\Http\Controllers\BnBOwner\ProfileController;
use App\Http\Controllers\BnBOwner\BnbRuleController;
use App\Http\Controllers\BnBOwner\RoleManagementController;

// BnB Owner Routes
Route::middleware(['auth', 'role:bnbowner,bnbonwner'])->group(function () {
    // Dashboard Routes
    Route::get('/bnbowner/motel-selection', [DashboardController::class, 'motelSelection'])->name('bnbowner.motel-selection');
    Route::get('/bnbowner/dashboard', [DashboardController::class, 'index'])->name('bnbowner.dashboard');
    Route::post('/bnbowner/select-motel', [DashboardController::class, 'selectMotel'])->name('bnbowner.select-motel');
    Route::get('/bnbowner/switch-account', [DashboardController::class, 'switchAccount'])->name('bnbowner.switch-account');
    
    // Motel Registration Routes (Owner adds new motel)
    Route::get('/bnbowner/motel/create', [DashboardController::class, 'createMotel'])->name('bnbowner.motel.create');
    Route::post('/bnbowner/motel/store', [DashboardController::class, 'storeMotel'])->name('bnbowner.motel.store');
    
    // Hotel Management Routes
    Route::get('/bnbowner/hotel-management', [HotelManagementController::class, 'index'])->name('bnbowner.hotel-management.index');
    Route::put('/bnbowner/hotel-management/motel', [HotelManagementController::class, 'updateMotel'])->name('bnbowner.hotel-management.update-motel');
    Route::put('/bnbowner/hotel-management/details', [HotelManagementController::class, 'updateMotelDetails'])->name('bnbowner.hotel-management.update-details');
    
    // Hotel Facilities (Amenities) Management
    Route::get('/bnbowner/hotel-facilities', [AmenityManagementController::class, 'index'])->name('bnbowner.hotel-facilities.index');
    Route::post('/bnbowner/hotel-facilities', [AmenityManagementController::class, 'store'])->name('bnbowner.hotel-facilities.store');
    Route::delete('/bnbowner/hotel-facilities/{amenity}', [AmenityManagementController::class, 'destroy'])->name('bnbowner.hotel-facilities.destroy');
    Route::get('/bnbowner/hotel-facilities/{amenity}/images', [AmenityManagementController::class, 'images'])->name('bnbowner.hotel-facilities.images');
    Route::post('/bnbowner/hotel-facilities/{amenity}/images', [AmenityManagementController::class, 'uploadImage'])->name('bnbowner.hotel-facilities.images.store');
    Route::delete('/bnbowner/hotel-facilities/{amenity}/images/{image}', [AmenityManagementController::class, 'destroyImage'])->name('bnbowner.hotel-facilities.images.destroy');

    // Hotel Images Management
    Route::get('/bnbowner/hotel-images', [HotelImageController::class, 'index'])->name('bnbowner.hotel-images.index');
    Route::post('/bnbowner/hotel-images', [HotelImageController::class, 'store'])->name('bnbowner.hotel-images.store');
    Route::delete('/bnbowner/hotel-images/{image}', [HotelImageController::class, 'destroy'])->name('bnbowner.hotel-images.destroy');
    
    // Room Management Routes
    Route::get('/bnbowner/room-management', [RoomManagementController::class, 'index'])->name('bnbowner.room-management.index');
    Route::get('/bnbowner/room-management/create', [RoomManagementController::class, 'create'])->name('bnbowner.room-management.create');
    Route::post('/bnbowner/room-management', [RoomManagementController::class, 'store'])->name('bnbowner.room-management.store');
    Route::get('/bnbowner/room-management/{id}/edit', [RoomManagementController::class, 'edit'])->name('bnbowner.room-management.edit');
    Route::put('/bnbowner/room-management/{id}', [RoomManagementController::class, 'update'])->name('bnbowner.room-management.update');
    Route::delete('/bnbowner/room-management/{id}', [RoomManagementController::class, 'destroy'])->name('bnbowner.room-management.destroy');
    
    // Room Items Routes
    Route::get('/bnbowner/room-items/{roomId}', [RoomItemController::class, 'index'])->name('bnbowner.room-items.index');
    Route::get('/bnbowner/room-items/{roomId}/create', [RoomItemController::class, 'create'])->name('bnbowner.room-items.create');
    Route::post('/bnbowner/room-items/{roomId}', [RoomItemController::class, 'store'])->name('bnbowner.room-items.store');
    Route::get('/bnbowner/room-items/{roomId}/{itemId}/edit', [RoomItemController::class, 'edit'])->name('bnbowner.room-items.edit');
    Route::put('/bnbowner/room-items/{roomId}/{itemId}', [RoomItemController::class, 'update'])->name('bnbowner.room-items.update');
    Route::delete('/bnbowner/room-items/{roomId}/{itemId}', [RoomItemController::class, 'destroy'])->name('bnbowner.room-items.destroy');
    
    // Room Images Routes
    Route::get('/bnbowner/room-images/{roomId}', [RoomImageController::class, 'index'])->name('bnbowner.room-images.index');
    Route::get('/bnbowner/room-images/{roomId}/create', [RoomImageController::class, 'create'])->name('bnbowner.room-images.create');
    Route::post('/bnbowner/room-images/{roomId}', [RoomImageController::class, 'store'])->name('bnbowner.room-images.store');
    Route::get('/bnbowner/room-images/{roomId}/{imageId}/edit', [RoomImageController::class, 'edit'])->name('bnbowner.room-images.edit');
    Route::put('/bnbowner/room-images/{roomId}/{imageId}', [RoomImageController::class, 'update'])->name('bnbowner.room-images.update');
    Route::delete('/bnbowner/room-images/{roomId}/{imageId}', [RoomImageController::class, 'destroy'])->name('bnbowner.room-images.destroy');
    
    // Staff Management Routes
    Route::get('/bnbowner/staff-management', [StaffManagementController::class, 'index'])->name('bnbowner.staff-management.index');
    Route::get('/bnbowner/staff-management/create', [StaffManagementController::class, 'create'])->name('bnbowner.staff-management.create');
    Route::post('/bnbowner/staff-management', [StaffManagementController::class, 'store'])->name('bnbowner.staff-management.store');
    Route::get('/bnbowner/staff-management/{id}/edit', [StaffManagementController::class, 'edit'])->name('bnbowner.staff-management.edit');
    Route::put('/bnbowner/staff-management/{id}', [StaffManagementController::class, 'update'])->name('bnbowner.staff-management.update');
    Route::post('/bnbowner/staff-management/{id}/reset-password', [StaffManagementController::class, 'resetPassword'])->name('bnbowner.staff-management.reset-password');
    Route::patch('/bnbowner/staff-management/{id}/toggle-status', [StaffManagementController::class, 'toggleStatus'])->name('bnbowner.staff-management.toggle-status');

    // Guest Chat Routes
    Route::get('/bnbowner/chats', [ChatController::class, 'index'])->name('bnbowner.chats.index');
    Route::get('/bnbowner/chats/{chat}', [ChatController::class, 'show'])->name('bnbowner.chats.show');
    Route::post('/bnbowner/chats/{chat}/send', [ChatController::class, 'sendMessage'])->name('bnbowner.chats.send');

    // Profile Management
    Route::get('/bnbowner/profile', [ProfileController::class, 'edit'])->name('bnbowner.profile.edit');
    Route::post('/bnbowner/profile', [ProfileController::class, 'updateProfile'])->name('bnbowner.profile.update');
    Route::post('/bnbowner/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('bnbowner.profile.update-avatar');
    Route::post('/bnbowner/profile/password', [ProfileController::class, 'updatePassword'])->name('bnbowner.profile.update-password');
    
    // BNB Rules Management Routes
    Route::get('/bnbowner/bnb-rules', [BnbRuleController::class, 'index'])->name('bnbowner.bnb-rules.index');
    Route::post('/bnbowner/bnb-rules', [BnbRuleController::class, 'store'])->name('bnbowner.bnb-rules.store');
    Route::put('/bnbowner/bnb-rules/{id}', [BnbRuleController::class, 'update'])->name('bnbowner.bnb-rules.update');
    Route::delete('/bnbowner/bnb-rules/{id}', [BnbRuleController::class, 'destroy'])->name('bnbowner.bnb-rules.destroy');

    // Role Management Routes
    Route::get('/bnbowner/role-management', [RoleManagementController::class, 'index'])->name('bnbowner.role-management.index');
    Route::get('/bnbowner/role-management/create', [RoleManagementController::class, 'create'])->name('bnbowner.role-management.create');
    Route::post('/bnbowner/role-management', [RoleManagementController::class, 'store'])->name('bnbowner.role-management.store');
    Route::get('/bnbowner/role-management/{id}/edit', [RoleManagementController::class, 'edit'])->name('bnbowner.role-management.edit');
    Route::put('/bnbowner/role-management/{id}', [RoleManagementController::class, 'update'])->name('bnbowner.role-management.update');
    Route::delete('/bnbowner/role-management/{id}', [RoleManagementController::class, 'destroy'])->name('bnbowner.role-management.destroy');
});