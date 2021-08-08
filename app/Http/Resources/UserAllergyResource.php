<?php

namespace App\Http\Resources;

use App\Http\Models\Allergy;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAllergyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => Carbon::parse($this->created_at)->format('F jS, Y'),
            'updated_at' => Carbon::parse($this->created_at)->format('F jS, Y'),
            'meals' => Allergy::find($this->id)->meals
        ];
    }
}
