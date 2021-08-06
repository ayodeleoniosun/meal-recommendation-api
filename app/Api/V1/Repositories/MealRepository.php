<?php

namespace App\Api\V1\Repositories;

use App\Exceptions\CustomApiErrorResponseHandler;
use App\Api\V1\Models\Meal;
use App\Api\V1\Interfaces\MealInterface;
use App\Api\V1\Models\ActiveStatus;
use App\Api\V1\Models\MealToAllergy;
use App\Api\V1\Models\User;
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

    public function show(int $id): array
    {
        $meal = Meal::find($id);
        
        if (!$meal || $meal->active_status != ActiveStatus::ACTIVE) {
            throw new CustomApiErrorResponseHandler("Meal not found");
        }
        
        return [
            'status' => 'success',
            'meal' => new MealResource($meal)
        ];
    }

    public function userRecommendations(array $data): array
    {
        $data = (object) $data;
        $user = User::find($data->auth_user->id);
        $userAllergies = $user->allergies->pluck('id')->toArray();
        
        $meals = MealToAllergy::distinct()->whereNotIn('allergy_id', $userAllergies)->active()->pluck('meal_id')->toArray();
        $recommendations = Meal::whereIn('id', $meals)->active()->get();

        return [
            'status' => 'success',
            'recommendations' => MealResource::collection($recommendations)
        ];
    }

    public function recommendations(array $data): array
    {
        $data = (object) $data;
        $users = $data->users;
        $recommendations = [];

        foreach ($users as $user) {
            $user = User::find($user);

            if ($user) {
                $userAllergies = $user->allergies->pluck('id')->toArray();
                $meals = MealToAllergy::distinct()->whereNotIn('allergy_id', $userAllergies)->active()->pluck('meal_id')->toArray();
                
                $recommendations[] = [
                    'user' => $user,
                    'recommendations' => Meal::whereIn('id', $meals)->active()->get()
                ];
            }
        }

        return [
            'status' => 'success',
            'recommendations' => $recommendations
        ];
    }
}
