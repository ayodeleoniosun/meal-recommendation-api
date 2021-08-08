<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class MealResource extends JsonResource
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
            'main_item' => new MainItemResource($this->mainItem),
            'side_items' => SideItemResource::collection($this->sideItems),
            'allergies' => AllergyResource::collection($this->allergies),
            'created_at' => Carbon::parse($this->created_at)->format('F jS, Y'),
            'updated_at' => Carbon::parse($this->created_at)->format('F jS, Y'),
        ];
    }
}
