<?php

namespace App\Api\V1\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allergy extends Model
{
    use HasFactory;

    protected $table = 'allergies';
    protected $fillable = ['name'];

    public function meals()
    {
        return $this->belongsToMany(Meal::class, 'meal_to_allergies');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_to_allergies');
    }
}
