<?php

namespace App\Api\V1\Repositories;

use App\Exceptions\CustomApiErrorResponseHandler;
use App\Api\V1\Models\Allergy;
use App\Api\V1\Interfaces\AllergyInterface;
use App\Api\V1\Models\User;
use App\Api\V1\Models\UserToAllergy;
use App\Api\V1\Resources\UserAllergyResource;

class AllergyRepository implements AllergyInterface
{
    public function myAllergies(array $data): array
    {
        $data = (object) $data;
        $user = User::find($data->auth_user->id);
        $allergies = $user->allergies;
        
        if ($allergies->count() == 0) {
            throw new CustomApiErrorResponseHandler("You haven't picked any allergy");
        }
        
        return [
            'status' => 'success',
            'allergies' => UserAllergyResource::collection($allergies)
        ];
    }

    public function pickAllergies(array $data): array
    {
        $data = (object) $data;
        $user = User::find($data->auth_user->id);
        
        $allergies = Allergy::whereIn('id', $data->allergies)->active()->pluck('id')->toArray();
        
        if (count($allergies) == 0) {
            throw new CustomApiErrorResponseHandler("Allergies do not exist");
        }

        $userAllergies = collect($user->allergies->pluck('id')->toArray());
        $allAllergies = count($allergies) > count($userAllergies) ? collect($allergies)->diff($userAllergies) :
            collect($userAllergies)->diff($allergies);

        if (count($allAllergies) == 0) {
            throw new CustomApiErrorResponseHandler("No new allergy picked");
        }

        $userToAllergies = UserToAllergy::where('user_id', $data->auth_user->id)
            ->whereIn('allergy_id', $allAllergies)->pluck('allergy_id')->toArray();
        
        $newUserAllergies = [];

        foreach ($allAllergies as $allergy) {
            if (!in_array($allergy, $userToAllergies)) {
                $newUserAllergies[] = [
                    'user_id' => $data->auth_user->id,
                    'allergy_id' => $allergy
                ];
            }
        }

        UserToAllergy::insert($newUserAllergies);
        
        return [
            'status' => 'success',
            'message' => count($newUserAllergies).' allergies successfully picked'
        ];
    }
}
