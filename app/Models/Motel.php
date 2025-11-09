<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motel extends Model
{
    use HasFactory;

    protected $table = 'bnb_motels';

    protected $fillable = [
        'name',
        'description',
        'owner_id',
        'motel_type_id',
        'street_address',
        'district_id',
        'latitude',
        'longitude',
        'front_image',
        'created_by'
    ];

    // Relationship with BnbUser (owner)
    public function owner()
    {
        return $this->belongsTo(BnbUser::class, 'owner_id');
    }

    // Relationship with MotelType
    public function motelType()
    {
        return $this->belongsTo(MotelType::class, 'motel_type_id');
    }

    // Relationship with BnbUser (creator)
    public function creator()
    {
        return $this->belongsTo(BnbUser::class, 'created_by');
    }

    // Relationship with MotelDetail
    public function details()
    {
        return $this->hasOne(MotelDetail::class, 'motel_id');
    }

    // Relationship with District
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    // Relationship with Amenities
    public function amenities()
    {
        return $this->hasMany(BnbAmenity::class, 'bnb_motels_id');
    }

    // Relationship with Rooms
    public function rooms()
    {
        return $this->hasMany(BnbRoom::class, 'motelid');
    }

    // Relationship with Images
    public function images()
    {
        return $this->hasMany(BnbImage::class, 'bnb_motels_id');
    }

    // Relationship with BnbChat
    public function chats()
    {
        return $this->hasMany(BnbChat::class, 'motel_id');
    }
}
