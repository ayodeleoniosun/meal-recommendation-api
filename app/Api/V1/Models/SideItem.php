<?php

namespace App\Api\V1\Models;

use App\Api\V1\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SideItem extends Model
{
    use HasFactory;

    protected $table = 'side_items';
    protected $fillable = ['name'];

    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope);
    }

    public function meals()
    {
        return $this->belongsToMany(Meal::class, 'meal_to_side_items');
    }
}
