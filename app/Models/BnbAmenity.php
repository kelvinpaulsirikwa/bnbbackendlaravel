<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BnbAmenity extends Model
{
    use HasFactory;

    protected $table = 'bnb_amenities';

    protected $fillable = [
        'amenities_id',
        'bnb_motels_id',
        'description',
        'posted_by'
    ];

    // Relationship with Amenity
    public function amenity()
    {
        return $this->belongsTo(Amenity::class, 'amenities_id');
    }

    // Relationship with Motel
    public function motel()
    {
        return $this->belongsTo(Motel::class, 'bnb_motels_id');
    }

    // Relationship with BnbUser (posted by)
    public function postedBy()
    {
        return $this->belongsTo(BnbUser::class, 'posted_by');
    }

    // Relationship with BnbAmenityImage
    public function images()
    {
        return $this->hasMany(BnbAmenityImage::class, 'bnb_amenities_id');
    }
}
