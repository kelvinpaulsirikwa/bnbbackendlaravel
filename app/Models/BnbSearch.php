<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BnbSearch extends Model
{
    use HasFactory;

    protected $table = 'bnbsearch';

    protected $fillable = [
        'bnb_motels_id',
        'count',
    ];

    protected $casts = [
        'count' => 'integer',
    ];

    // Relationship with Motel
    public function motel()
    {
        return $this->belongsTo(Motel::class, 'bnb_motels_id');
    }

    // Method to increment search count
    public static function incrementSearchCount($motelId)
    {
        $motelId = (int) $motelId;
        $record = static::firstOrCreate(
            ['bnb_motels_id' => $motelId],
            ['count' => 0]
        );
        $record->increment('count');
        return $record->fresh();
    }
}
