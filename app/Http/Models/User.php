<?php

namespace App\Http\Models;

use App\Http\Scopes\ActiveScope;
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

    public function allergies()
    {
        return $this->belongsToMany(Allergy::class, 'user_to_allergies');
    }

    public static function getUserByEmail($email)
    {
        return self::where('email_address', $email)->first();
    }
}
