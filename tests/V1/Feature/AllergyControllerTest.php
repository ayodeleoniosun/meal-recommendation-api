<?php

namespace Tests\V1\Feature;

use App\Api\V1\Models\Allergy;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\V1\TestCase;
use Tests\V1\Traits\Allergy as TraitsAllergy;

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
        $response->assertStatus(200);
        $this->assertEquals($response->getData()->status, 'success');
    }
}
