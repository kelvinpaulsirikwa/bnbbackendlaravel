<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BnbRoom extends Model
{
    use HasFactory;

    protected $table = 'bnbrooms';

    protected $fillable = [
        'motelid',
        'room_number',
        'room_type_id',
        'price_per_night',
        'office_price_per_night',
        'frontimage',
        'description',
        'status',
        'is_active',
        'created_by',
    ];

    public function motel()
    {
        return $this->belongsTo(Motel::class, 'motelid');
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }

    public function creator()
    {
        return $this->belongsTo(BnbUser::class, 'created_by');
    }

    public function items()
    {
        return $this->hasMany(BnbRoomItem::class, 'bnbroomid');
    }

    public function images()
    {
        return $this->hasMany(BnbRoomImage::class, 'bnbroomid');
    }

    public function bookingDates()
    {
        return $this->hasMany(BnbBookingDate::class, 'bnb_room_id');
    }
}
