<?php

namespace App\Api\V1\Models;

use App\Api\V1\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $table = 'meals';
    protected $fillable = ['name'];

    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope);
    }

    
    public function mainItem()
    {
        return $this->hasOne(MainItem::class);
    }

    public function sideItems()
    {
        return $this->belongsToMany(SideItem::class, 'meal_to_side_items');
    }

    public function allergies()
    {
        return $this->belongsToMany(Allergy::class, 'meal_to_allergies');
    }
}
