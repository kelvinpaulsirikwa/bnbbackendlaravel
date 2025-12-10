<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BnbRule extends Model
{
    use HasFactory;

    protected $table = 'bnb_rules';

    protected $fillable = [
        'motel_id',
        'rules',
        'posted_by'
    ];

    // Relationship with Motel
    public function motel()
    {
        return $this->belongsTo(Motel::class, 'motel_id');
    }

    // Relationship with BnbUser (who posted the rules)
    public function postedBy()
    {
        return $this->belongsTo(BnbUser::class, 'posted_by');
    }
}
