<?php

namespace App\Api\V1\Repositories;

use App\Exceptions\CustomApiErrorResponseHandler;
use App\Api\ApiUtility;
use App\Api\V1\Models\Allergy;
use App\Api\V1\Interfaces\AllergyInterface;
use App\Api\V1\Models\ActiveStatus;
use App\Api\V1\Models\User;
use App\Api\V1\Models\UserToAllergy;
use App\Api\V1\Resources\UserAllergyResource;
use Illuminate\Support\Facades\Auth;

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
        $userAllergies = collect($user->allergies->pluck('id')->toArray());
        $allAllergies = count($allergies) > count($userAllergies) ? collect($allergies)->diff($userAllergies) :
            collect($userAllergies)->diff($allergies);

        if (count($allAllergies) == 0) {
            throw new CustomApiErrorResponseHandler("No allergy picked");
        }

        foreach ($allAllergies as $allergy) {
            UserToAllergy::create([
                'user_id' => $data->auth_user->id,
                'allergy_id' => $allergy
            ]);
        }
        
        $allergies = $user->load('allergies');
        
        return [
            'status' => 'success',
            'allergies' => $allergies->allergies,
            'message' => count($allAllergies).' allergies successfully picked'
        ];
    }
}
