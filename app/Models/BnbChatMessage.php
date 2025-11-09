<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BnbChatMessage extends Model
{
    use HasFactory;

    protected $table = 'bnb_chat_messages';

    public $timestamps = false; // Only has created_at, not updated_at

    protected $fillable = [
        'chat_id',
        'sender_type',
        'sender_id',
        'message',
        'read_status'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    // Relationship with BnbChat
    public function chat()
    {
        return $this->belongsTo(BnbChat::class, 'chat_id');
    }

    // Polymorphic-like relationship for sender (could be Customer or BnbUser)
    public function sender()
    {
        if ($this->sender_type === 'customer') {
            return $this->belongsTo(Customer::class, 'sender_id');
        } else {
            return $this->belongsTo(BnbUser::class, 'sender_id');
        }
    }

    // Relationship with BnbChatAttachment
    public function attachments()
    {
        return $this->hasMany(BnbChatAttachment::class, 'message_id');
    }

    // Override to handle created_at manually
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = now();
        });
    }
}
