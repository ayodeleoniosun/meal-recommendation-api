<?php

namespace Tests\Feature;

use App\Http\Models\Allergy;
use App\Http\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\Traits\Allergy as TraitsAllergy;

class AllergyControllerTest extends TestCase
{
    use DatabaseTransactions, TraitsAllergy;

    public function setUp(): void
    {
        parent::setup();
    }

    public function testPickAllergyFailure()
    {
        $response = $this->req()->json('POST', $this->route("/users/allergies"));
        $response->assertStatus(400);
        $this->assertEquals($response->getData()->status, 'error');
        $this->assertEquals($response->getData()->message, 'Select at least one allergy');
    }

    public function testPickAllergySuccessful()
    {
        $response = $this->pickAllergy();
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'status',
            'allergies',
            'message'
        ]);
    }

    public function testShowUserAllergies()
    {
        $allergies = $this->pickAllergy();
        $user_id = $allergies->getData()->allergies[0]->pivot->user_id;
        $token = User::find($user_id)->bearer_token;
        
        $response = $this->req($token)->json('GET', $this->route("/users/my-allergies"));
        $response->assertStatus(200);
        $this->assertEquals($response->getData()->status, 'success');
        $response->assertJsonStructure([
            'status',
            'allergies'
        ]);
    }
}
