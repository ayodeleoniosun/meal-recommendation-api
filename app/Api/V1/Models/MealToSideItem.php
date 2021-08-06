<?php

namespace App\Api\V1\Models;

use App\Api\V1\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealToSideItem extends Model
{
    use HasFactory;

    protected $table = 'meal_to_side_items';

    public function scopeActive($query)
    {
        return $query->where('active_status', ActiveStatus::ACTIVE);
    }
}
