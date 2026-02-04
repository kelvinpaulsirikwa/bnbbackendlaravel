<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotelRole extends Model
{
    use HasFactory;

    protected $table = 'motel_roles';

    protected $fillable = ['motel_id', 'name', 'permissions'];

    protected $casts = [
        'permissions' => 'array',
    ];

    public function motel()
    {
        return $this->belongsTo(Motel::class, 'motel_id');
    }
}
