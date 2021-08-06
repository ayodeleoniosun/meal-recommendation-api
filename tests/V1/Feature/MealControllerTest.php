<?php

namespace Tests\V1\Feature;

use App\Api\V1\Models\Allergy;
use App\Api\V1\Models\MainItem;
use App\Api\V1\Models\Meal;
use App\Api\V1\Models\MealToAllergy;
use App\Api\V1\Models\MealToSideItem;
use App\Api\V1\Models\SideItem;
use App\Api\V1\Models\User;
use Tests\V1\Traits\Allergy as TraitsAllergy;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\V1\TestCase;

class MealControllerTest extends TestCase
{
    use DatabaseTransactions, TraitsAllergy;

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
            'meals' => [
                '*' => [
                    'id', 'name', 'created_at', 'updated_at', 'active_status',
                    'main_item' => [
                        'id', 'name', 'created_at', 'updated_at', 'active_status'
                    ],
                    'side_items' => [
                        '*' => ['id', 'name', 'created_at', 'updated_at', 'active_status']
                    ]
                ]
            ]
        ]);
    }

    public function testShowSingleMeal()
    {
        $count = 1;
        $allergies = factory(Allergy::class, 3)->create();
        $meal = factory(Meal::class, $count)->create();
        $meal = Meal::find($meal[0]->id);
        $sideItems = factory(SideItem::class, 5)->create();

        DB::transaction(function () use ($meal, $allergies, $sideItems, $count) {
            factory(MainItem::class, $count)->create([
                'meal_id' => $meal->id
            ]);

            $sideItems = $sideItems->random(3);

            foreach ($sideItems as $side_item) {
                factory(MealToSideItem::class, $count)->create([
                    'meal_id' => $meal->id,
                    'side_item_id' => $side_item->id
                ]);
            }

            $allergy = $allergies->random(2)->first();
            
            foreach ($allergies as $allergy) {
                factory(MealToAllergy::class, $count)->create([
                    'meal_id' => $meal->id,
                    'allergy_id' => $allergy->id
                ]);
            }
        });

        $response = $this->json('GET', $this->route("/meals/".$meal->id));
        $response->assertStatus(200);
        $this->assertEquals($response->getData()->status, 'success');
        $response->assertJsonStructure([
            'status',
            'meal' => [
                'id', 'name', 'created_at', 'updated_at', 'active_status',
                'main_item' => [
                    'id', 'name', 'created_at', 'updated_at', 'active_status'
                ],
                'side_items' => [
                    '*' => ['id', 'name', 'created_at', 'updated_at', 'active_status']
                ]
            ]
        ]);
    }

    public function testRecommendMealForSingleUser()
    {
        $allergies = $this->pickAllergy();
        $user_id = $allergies->getData()->allergies[0]->pivot->user_id;
        $token = User::find($user_id)->bearer_token;

        $response = $this->req($token)->json('GET', $this->route("/users/meals/recommendations"));
        $response->assertStatus(200);
        $this->assertEquals($response->getData()->status, 'success');
        $response->assertJsonStructure([
            'status',
            'recommendations' => [
                '*' => [
                    'id', 'name', 'created_at', 'updated_at', 'active_status',
                    'main_item' => [
                        'id', 'name', 'created_at', 'updated_at', 'active_status'
                    ],
                    'side_items' => [
                        '*' => ['id', 'name', 'created_at', 'updated_at', 'active_status']
                    ]
                ]
            ]
        ]);
    }

    public function testRecommendMealForMultipleUsers()
    {
        $users = factory(User::class, 3)->create();
        $users = $users->pluck('id')->toArray();
        
        foreach ($users as $user) {
            $token = User::find($user)->bearer_token;
            $this->pickAllergy($token);
        }
        
        $response = $this->req($token)->json('POST', $this->route("/meals/recommendations"), ["users" => $users]);
        $response->assertStatus(200);
        $this->assertEquals($response->getData()->status, 'success');
        $response->assertJsonStructure([
            'status',
            'recommendations' => [
                '*' => [
                    'user' => ['id', 'first_name', 'last_name', 'email_address', 'phone_number', 'created_at', 'updated_at', 'active_status'],
                    'recommendations' => [
                        '*' => ['id', 'name', 'created_at', 'updated_at', 'active_status']
                    ]
                ]
            ]
        ]);
    }
}
