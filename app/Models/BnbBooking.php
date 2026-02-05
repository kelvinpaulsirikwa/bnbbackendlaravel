<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BnbBooking extends Model
{
    use HasFactory;

    protected $table = 'bnb_bookings';

    protected $fillable = [
        'customer_id',
        'bnb_room_id',
        'check_in_date',
        'check_out_date',
        'number_of_nights',
        'price_per_night',
        'total_amount',
        'contact_number',
        'status',
        'special_requests',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    // Relationship with Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Relationship with BnbRoom
    public function room()
    {
        return $this->belongsTo(BnbRoom::class, 'bnb_room_id');
    }

    // Relationship with Motel (through room)
    public function motel()
    {
        return $this->hasOneThrough(Motel::class, BnbRoom::class, 'id', 'id', 'bnb_room_id', 'motelid');
    }

    // Relationship with BnbTransaction
    public function transactions()
    {
        return $this->hasMany(BnbTransaction::class, 'booking_id');
    }

    public function bookingDates()
    {
        return $this->hasMany(BnbBookingDate::class, 'booking_id');
    }

    // Relationship with BnbChat
    public function chats()
    {
        return $this->hasMany(BnbChat::class, 'booking_id');
    }
}
