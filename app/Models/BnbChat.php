<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BnbChat extends Model
{
    use HasFactory;

    protected $table = 'bnb_chats';

    protected $fillable = [
        'booking_id',
        'motel_id',
        'customer_id',
        'started_by',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationship with BnbBooking
    public function booking()
    {
        return $this->belongsTo(BnbBooking::class, 'booking_id');
    }

    // Relationship with Motel
    public function motel()
    {
        return $this->belongsTo(Motel::class, 'motel_id');
    }

    // Relationship with Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Relationship with BnbChatMessage
    public function messages()
    {
        return $this->hasMany(BnbChatMessage::class, 'chat_id');
    }
}
