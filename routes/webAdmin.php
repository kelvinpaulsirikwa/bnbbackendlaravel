<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('adminpages')->name('adminpages.')->middleware('auth')->group(function () {
    Route::resource('users', App\Http\Controllers\Admin\BnbUserController::class);
    Route::resource('countries', App\Http\Controllers\Admin\CountryController::class);
    Route::resource('regions', App\Http\Controllers\Admin\RegionController::class);
    Route::resource('districts', App\Http\Controllers\Admin\DistrictController::class);
    Route::resource('amenities', App\Http\Controllers\Admin\AmenityController::class);
    Route::resource('customers', App\Http\Controllers\Admin\CustomerController::class);
    Route::resource('motel-types', App\Http\Controllers\Admin\MotelTypeController::class);
    Route::resource('room-types', App\Http\Controllers\Admin\RoomTypeController::class);
    Route::resource('motels', App\Http\Controllers\Admin\MotelController::class);
    Route::resource('motel-details', App\Http\Controllers\Admin\MotelDetailController::class);
    Route::resource('contact-messages', App\Http\Controllers\Admin\ContactMessageController::class)->only(['index', 'show', 'destroy']);
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/chats', [App\Http\Controllers\Admin\ChatController::class, 'index'])->name('chats.index');
    Route::get('/chats/{chat}', [App\Http\Controllers\Admin\ChatController::class, 'show'])->name('chats.show');
    Route::post('/chats/{chat}/send', [App\Http\Controllers\Admin\ChatController::class, 'sendMessage'])->name('chats.send');
});

// Authentication routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
