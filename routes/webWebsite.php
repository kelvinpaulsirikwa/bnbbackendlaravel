<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Website\GalleryController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\ContactMessageController;
use App\Http\Controllers\Website\AmenityController;
use App\Http\Controllers\Website\MotelController;
use App\Http\Controllers\Website\RoomController;

Route::controller(HomeController::class)
    ->as('website.')
    ->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('/about', 'about')->name('about');
        Route::get('/services', 'services')->name('services');
        Route::get('/contact', 'contact')->name('contact');
    });

Route::post('/contact', [ContactMessageController::class, 'store'])->name('website.contact.store');
Route::get('/gallery', [GalleryController::class, 'index'])->name('website.gallery');
Route::get('/amenities', [AmenityController::class, 'index'])->name('website.amenities');

Route::get('/motels', [MotelController::class, 'index'])->name('website.motels.index');
Route::get('/motels/{motel}', [MotelController::class, 'show'])->name('website.motels.show');
Route::get('/motels/{motel}/rooms/{room}', [RoomController::class, 'show'])->name('website.rooms.show');
