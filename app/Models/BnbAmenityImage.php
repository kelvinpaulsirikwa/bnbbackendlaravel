<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BnbAmenityImage extends Model
{
    use HasFactory;

    protected $table = 'bnb_amenities_image';

    protected $fillable = [
        'bnb_amenities_id',
        'filepath',
        'description',
        'posted_by'
    ];

    // Relationship with BnbAmenity
    public function bnbAmenity()
    {
        return $this->belongsTo(BnbAmenity::class, 'bnb_amenities_id');
    }

    // Relationship with BnbUser (posted by)
    public function postedBy()
    {
        return $this->belongsTo(BnbUser::class, 'posted_by');
    }
}
