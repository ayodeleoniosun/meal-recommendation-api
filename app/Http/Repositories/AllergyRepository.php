<?php

namespace App\Http\Repositories;

use App\Exceptions\CustomApiErrorResponseHandler;
use App\Http\Models\Allergy;
use App\Http\Interfaces\AllergyInterface;
use App\Http\Models\User;
use App\Http\Models\UserToAllergy;
use App\Http\Resources\UserAllergyResource;

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
        
        $allergies = Allergy::whereIn('id', $data->allergies)->pluck('id')->toArray();
        
        if (count($allergies) == 0) {
            throw new CustomApiErrorResponseHandler("Allergies do not exist");
        }

        $userToAllergies = UserToAllergy::where('user_id', $user->id)
            ->whereIn('allergy_id', $allergies)->pluck('allergy_id')->toArray();
        
        $newUserAllergies = [];

        foreach ($allergies as $allergy) {
            if (!in_array($allergy, $userToAllergies)) {
                $newUserAllergies[] = [
                    'user_id' => $user->id,
                    'allergy_id' => $allergy
                ];
            }
        }

        if (count($newUserAllergies) == 0) {
            throw new CustomApiErrorResponseHandler("No new allergy picked");
        }

        UserToAllergy::insert($newUserAllergies);
        
        return [
            'status' => 'success',
            'message' => count($newUserAllergies).' allergies successfully picked'
        ];
    }
}
