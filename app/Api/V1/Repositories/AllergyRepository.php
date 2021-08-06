<?php

namespace App\Api\V1\Repositories;

use App\Exceptions\CustomApiErrorResponseHandler;
use App\Api\ApiUtility;
use App\Api\V1\Models\Allergy;
use App\Api\V1\Interfaces\AllergyInterface;
use App\Api\V1\Models\ActiveStatus;
use App\Api\V1\Models\User;
use App\Api\V1\Models\UserToAllergy;
use Illuminate\Support\Facades\Auth;

class AllergyRepository implements AllergyInterface
{
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

        return [
            'status' => 'success',
            'message' => count($allAllergies).' allergies successfully picked'
        ];
    }
}
