<?php

namespace App\Api\V1\Repositories;

use App\Exceptions\CustomApiErrorResponseHandler;
use App\Api\V1\Models\Meal;
use App\Api\V1\Interfaces\MealInterface;
use App\Api\V1\Resources\MealResource;

class MealRepository implements MealInterface
{
    public function index(array $data): array
    {
        $data = (object) $data;
        $meals = Meal::active()->get();
        
        if ($meals->count() == 0) {
            throw new CustomApiErrorResponseHandler("No meals yet");
        }
        
        return [
            'status' => 'success',
            'meals' => MealResource::collection($meals)
        ];
    }
}
