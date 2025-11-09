<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BnbChatAttachment extends Model
{
    use HasFactory;

    protected $table = 'bnb_chat_attachments';

    public $timestamps = false; // Only has uploaded_at, not standard timestamps

    protected $fillable = [
        'message_id',
        'file_path',
        'file_type',
        'uploaded_by'
    ];

    protected $casts = [
        'uploaded_at' => 'datetime'
    ];

    // Relationship with BnbChatMessage
    public function message()
    {
        return $this->belongsTo(BnbChatMessage::class, 'message_id');
    }

    // Override to handle uploaded_at manually
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uploaded_at = now();
        });
    }
}
