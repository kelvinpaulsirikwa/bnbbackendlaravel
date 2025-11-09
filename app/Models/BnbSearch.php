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
        return static::updateOrCreate(
            ['bnb_motels_id' => $motelId],
            ['count' => \DB::raw('count + 1')]
        );
    }
}
