<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Website\AmenityController;
use App\Http\Controllers\Website\AuthController;
use App\Http\Controllers\Website\ContactMessageController;
use App\Http\Controllers\Website\GalleryController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\LanguageController;
use App\Http\Controllers\Website\MotelAmenityController;
use App\Http\Controllers\Website\MotelController;
use App\Http\Controllers\Website\RoomController;

Route::middleware('website.locale')->group(function () {
    Route::controller(HomeController::class)
        ->as('website.')
        ->group(function () {
            Route::get('/', 'index')->name('home');
            Route::get('/contact', 'contact')->name('contact');
        });

    Route::get('/register', [AuthController::class, 'register'])->name('website.auth.register');
    Route::post('/contact', [ContactMessageController::class, 'store'])->name('website.contact.store');
    Route::get('/gallery', [GalleryController::class, 'index'])->name('website.gallery');
    Route::get('/amenities', [AmenityController::class, 'index'])->name('website.amenities');
    Route::get('/amenities/{amenity}', [AmenityController::class, 'show'])->name('website.amenities.show');

    Route::get('/motels', [MotelController::class, 'index'])->name('website.motels.index');
    Route::get('/motels/{motel}', [MotelController::class, 'show'])->name('website.motels.show');
    Route::get('/motels/{motel}/gallery', [GalleryController::class, 'motelGallery'])->name('website.motels.gallery');
    Route::get('/motels/{motel}/amenities', [MotelAmenityController::class, 'index'])->name('website.motels.amenities');
    Route::get('/motels/{motel}/rooms/{room}', [RoomController::class, 'show'])->name('website.rooms.show');

    Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('website.language.switch');
});
