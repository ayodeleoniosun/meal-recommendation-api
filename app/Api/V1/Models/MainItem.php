<?php

namespace App\Api\V1\Models;

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
