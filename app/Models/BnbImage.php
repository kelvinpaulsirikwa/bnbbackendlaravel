<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BnbImage extends Model
{
    use HasFactory;

    protected $table = 'bnb_image';

    protected $fillable = [
        'bnb_motels_id',
        'filepath',
        'posted_by'
    ];

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
}
