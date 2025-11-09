<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BnbTransaction extends Model
{
    use HasFactory;

    protected $table = 'bnb_transactions';

    protected $fillable = [
        'booking_id',
        'transaction_id',
        'amount',
        'payment_method',
        'payment_reference',
        'status',
        'payment_details',
        'gateway_response',
        'processed_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'processed_at' => 'datetime'
    ];

    // Relationship with BnbBooking
    public function booking()
    {
        return $this->belongsTo(BnbBooking::class, 'booking_id');
    }
}
