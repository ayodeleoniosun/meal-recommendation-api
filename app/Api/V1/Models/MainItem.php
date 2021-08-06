<?php

namespace App\Api\V1\Models;

use App\Api\V1\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainItem extends Model
{
    use HasFactory;

    protected $table = 'main_items';
    protected $fillable = ['name'];

    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope);
    }

    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }
}
