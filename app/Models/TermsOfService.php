<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermsOfService extends Model
{
    use HasFactory;

    protected $table = 'terms_of_service';

    protected $fillable = ['title', 'content', 'is_active', 'created_by'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(\App\Models\BnbUser::class, 'created_by');
    }

    /**
     * Get the currently active terms (single record for display).
     */
    public static function getActive()
    {
        return static::where('is_active', true)->first();
    }
}
