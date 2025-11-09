<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BnbRoomImage extends Model
{
    use HasFactory;

    protected $table = 'bnbroomimage';

    protected $fillable = [
        'bnbroomid',
        'imagepath',
        'description',
        'created_by'
    ];

    public function room()
    {
        return $this->belongsTo(BnbRoom::class, 'bnbroomid');
    }

    public function creator()
    {
        return $this->belongsTo(BnbUser::class, 'created_by');
    }
}
