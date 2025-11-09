<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable = ['countryid','name','createdby'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'countryid');
    }

    public function districts()
    {
        return $this->hasMany(District::class, 'regionid');
    }
}
