<?php

namespace App\Api\V1\Models;

use App\Api\V1\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserToAllergy extends Model
{
    use HasFactory;

    protected $table = 'user_to_allergies';
    protected $fillable = ['user_id', 'allergy_id'];
}
