<?php

namespace App\Api\V1\Resources;

use App\Api\V1\Models\ActiveStatus;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SideItemResource extends JsonResource
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
            'active_status' => ActiveStatus::getStatusName($this->active_status)
        ];
    }
}
