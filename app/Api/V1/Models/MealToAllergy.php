<?php

namespace App\Api\V1\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealToAllergy extends Model
{
    use HasFactory;

    protected $table = 'meal_to_allergies';
}
