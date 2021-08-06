<?php

namespace Tests\V1\Feature;

use App\Api\V1\Models\Allergy;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\V1\TestCase;

class AllergyControllerTest extends TestCase
{
    use DatabaseTransactions;

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
        $allergies = factory(Allergy::class, 3)->create();
        $allergies = $allergies->pluck('id')->toArray();
        
        $response = $this->req()->json('POST', $this->route("/users/allergies"), ["allergies" => $allergies]);
        $response->assertStatus(200);
        $this->assertEquals($response->getData()->status, 'success');
        $this->assertEquals($response->getData()->message, count($allergies).' allergies successfully picked');
    }
}
