<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $table = 'customers';
    
    protected $fillable = [
        'username',
        'useremail', 
        'userimage',
        'phonenumber',
        'password'
    ];

    protected $hidden = ['password'];

    // Use useremail as the username field for authentication
    public function getAuthIdentifierName()
    {
        return 'useremail';
    }

    // Override to use useremail instead of email for authentication
    public function getEmailForPasswordReset()
    {
        return $this->useremail;
    }

    // Relationship with BnbChat
    public function chats()
    {
        return $this->hasMany(BnbChat::class, 'customer_id');
    }
}
