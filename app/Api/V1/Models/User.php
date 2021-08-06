<?php

namespace App\Api\V1\Models;

use App\Api\V1\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'users';
    
    protected $hidden = ['password'];

    protected $fillable = [
        'first_name',
        'last_name',
        'email_address',
        'phone_number',
        'password',
        'bearer_token'
    ];

    public function scopeActive($query)
    {
        return $query->where('active_status', ActiveStatus::ACTIVE);
    }
    
    public function allergies()
    {
        return $this->belongsToMany(Allergy::class, 'user_to_allergies');
    }

    public static function getUserByEmail($email)
    {
        return self::where('email_address', $email)->first();
    }
}
