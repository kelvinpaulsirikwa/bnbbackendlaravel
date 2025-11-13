<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotelDetail extends Model
{
    use HasFactory;

    protected $table = 'bnb_motel_details';

    protected $fillable = [
        'motel_id',
        'street_address',
        'district_id',
        'latitude',
        'longitude',
        'front_image',
        'contact_phone',
        'contact_email',
        'total_rooms',
        'available_rooms',
        'status',
        'rate',
    ];

    // Relationship with Motel
    public function motel()
    {
        return $this->belongsTo(Motel::class, 'motel_id');
    }

}
