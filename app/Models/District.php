<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = ['regionid','name','createdby'];

    public function region()
    {
        return $this->belongsTo(Region::class, 'regionid');
    }

    public function motels()
    {
        return $this->hasMany(Motel::class, 'district_id');
    }
}
