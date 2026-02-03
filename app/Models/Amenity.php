<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    use HasFactory;

    protected $fillable = ['name','icon','createdby'];

    /**
     * Get the full path for the icon (relative to public). Handles old DB values that stored only filename.
     */
    public function getIconPathAttribute(): string
    {
        if (empty($this->icon)) {
            return '';
        }
        $icon = $this->icon;
        if (strpos($icon, '/') === false && strpos($icon, '\\') === false) {
            return 'images/amenities/' . ltrim($icon, '/');
        }
        return $icon;
    }

    /**
     * Get the full URL for the icon. Returns placeholder URL if file is missing (avoids 404s).
     */
    public function getIconUrlAttribute(): ?string
    {
        if (empty($this->icon)) {
            return null;
        }
        $path = $this->icon_path;
        $fullPath = public_path($path);
        if (!file_exists($fullPath)) {
            return asset('images/noimage.png');
        }
        return asset($path);
    }

    // Relationship with BnbAmenity
    public function bnbAmenities()
    {
        return $this->hasMany(BnbAmenity::class, 'amenities_id');
    }
}
