<?php

namespace App\Http\Models;

use App\Http\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainItem extends Model
{
    use HasFactory;

    protected $table = 'main_items';
    protected $fillable = ['name'];

    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }
}
