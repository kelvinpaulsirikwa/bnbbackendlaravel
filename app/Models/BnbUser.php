<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class BnbUser extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'bnb_users';

    protected $fillable = [
        'username','useremail','profileimage','password','telephone','status','role','createdby','motel_id','admin_permissions'
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'admin_permissions' => 'array',
    ];

    // Use useremail as the username field for authentication
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    // Override to return the actual ID for authentication
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    // Override to use useremail for authentication attempts
    public function getAuthPassword()
    {
        return $this->password;
    }

    // Override to use useremail instead of email for authentication
    public function getEmailForPasswordReset()
    {
        return $this->useremail;
    }

    // Relationship with Motel
    public function motel()
    {
        return $this->belongsTo(\App\Models\Motel::class, 'motel_id');
    }
}
