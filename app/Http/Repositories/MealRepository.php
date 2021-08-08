<?php

namespace App\Http\Repositories;

use App\Exceptions\CustomApiErrorResponseHandler;
use App\Http\Models\Meal;
use App\Http\Interfaces\MealInterface;
use App\Http\Models\ActiveStatus;
use App\Http\Models\MealToAllergy;
use App\Http\Models\User;
use App\Http\Resources\MealResource;

class MealRepository implements MealInterface
{
    public function index(array $data): array
    {
        $data = (object) $data;
        $meals = Meal::all();
        
        if ($meals->count() == 0) {
            throw new CustomApiErrorResponseHandler("No meals yet");
        }
        
        return [
            'status' => 'success',
            'meals' => MealResource::collection($meals)
        ];
    }

    public function find(int $id): array
    {
        $meal = Meal::find($id);
        
        if (!$meal) {
            throw new CustomApiErrorResponseHandler("Meal not found");
        }
        
        return [
            'status' => 'success',
            'meal' => new MealResource($meal)
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
                $meals = MealToAllergy::distinct()->whereNotIn('allergy_id', $userAllergies)->pluck('meal_id')->toArray();
                
                $recommendations[] = [
                    'user' => $user,
                    'recommendations' => Meal::whereIn('id', $meals)->get()
                ];
            }
        }

        return [
            'status' => 'success',
            'recommendations' => $recommendations
        ];
    }
}
