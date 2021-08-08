<?php

namespace App\Http\Models;

use App\Http\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealToAllergy extends Model
{
    use HasFactory;

    protected $table = 'meal_to_allergies';
}
