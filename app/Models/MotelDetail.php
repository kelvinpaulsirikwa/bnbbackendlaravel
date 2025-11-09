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
        'contact_phone',
        'contact_email',
        'total_rooms',
        'available_rooms',
        'status'
    ];

    // Relationship with Motel
    public function motel()
    {
        return $this->belongsTo(Motel::class, 'motel_id');
    }

}
