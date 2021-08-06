<?php

namespace Tests\V1\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\V1\TestCase;

class MealControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setup();
    }

    public function testShowAllMeals()
    {
        $response = $this->json('GET', $this->route("/meals"));
        $response->assertStatus(200);
        $this->assertEquals($response->getData()->status, 'success');
        $response->assertJsonStructure([
            'status',
            'meals'
        ]);
    }
}
