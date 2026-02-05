<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BnbBookingDate extends Model
{
    use HasFactory;

    protected $table = 'bnb_booking_dates';

    protected $fillable = [
        'booking_id',
        'bnb_room_id',
        'booked_date',
        'price_per_night',
    ];

    protected $casts = [
        'booked_date' => 'date',
        'price_per_night' => 'decimal:2',
    ];

    public function booking()
    {
        return $this->belongsTo(BnbBooking::class, 'booking_id');
    }

    public function room()
    {
        return $this->belongsTo(BnbRoom::class, 'bnb_room_id');
    }
}

