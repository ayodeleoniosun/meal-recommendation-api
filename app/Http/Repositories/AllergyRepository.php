<?php

namespace App\Http\Repositories;

use App\Exceptions\CustomApiErrorResponseHandler;
use App\Http\Interfaces\AllergyInterface;
use App\Http\Models\User;
use App\Http\Resources\UserAllergyResource;
class AllergyRepository implements AllergyInterface
{
    public function index(array $data): array
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

    public function store(array $data): array
    {
        $data = (object) $data;
        $user = User::find($data->auth_user->id);
        $allergies = array_merge($user->allergies->pluck('id')->toArray(), $data->allergies);
        $sync = $user->allergies()->sync($allergies);
        $countSynced = count($sync['attached']);

        if ($countSynced == 0) {
            throw new CustomApiErrorResponseHandler("No new allergies added");
        }

        return [
            'status' => 'success',
            'message' => $countSynced.' new allergies successfully added'
        ];
    }
}
