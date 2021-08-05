<?php

namespace App\Api\V1\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $fillable = ['name'];

    public function allergies()
    {
        return $this->belongsToMany(Allergy::class, 'user_to_allergies');
    }
}
