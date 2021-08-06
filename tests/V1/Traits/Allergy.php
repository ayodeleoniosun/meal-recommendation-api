<?php

namespace Tests\V1\Traits;

use App\Api\V1\Models\Allergy as AllergyModel;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;

trait Allergy
{
    use WithFaker;

    public function pickAllergy($token = null)
    {
        $allergies = factory(AllergyModel::class, 3)->create();
        $allergies = $allergies->pluck('id')->toArray();
        return $this->req($token)->json('POST', $this->route("/users/allergies"), ["allergies" => $allergies]);
    }
}
