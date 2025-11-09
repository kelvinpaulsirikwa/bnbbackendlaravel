<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    use HasFactory;

    protected $fillable = ['name','icon','createdby'];

    // Relationship with BnbAmenity
    public function bnbAmenities()
    {
        return $this->hasMany(BnbAmenity::class, 'amenities_id');
    }
}
