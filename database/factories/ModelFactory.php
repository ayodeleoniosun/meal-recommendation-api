<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/**
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */

use App\Api\V1\Models\Allergy;
use App\Api\V1\Models\MainItem;
use App\Api\V1\Models\Meal;
use App\Api\V1\Models\MealToAllergy;
use App\Api\V1\Models\MealToSideItem;
use App\Api\V1\Models\SideItem;
use App\Api\V1\Models\User;
use App\Api\V1\Models\UserToAllergy;

$factory->define(
    Allergy::class,
    function (Faker\Generator $faker) {
        return [
            'name' => $faker->name,
        ];
    }
);

$factory->define(
    Meal::class,
    function (Faker\Generator $faker) {
        return [
            'name' => $faker->name,
        ];
    }
);

 $factory->define(
     SideItem::class,
     function (Faker\Generator $faker) {
         return [
            'name' => $faker->name,
        ];
     }
 );

 $factory->define(
     User::class,
     function (Faker\Generator $faker) {
         return [
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'phone_number' => '080'.rand(111111111, 999999999),
            'email_address' => $faker->email,
            'password' => bcrypt('secret'),
            'bearer_token' => base64_encode(uniqid()),
        ];
     }
 );


 $factory->define(
     MainItem::class,
     function (Faker\Generator $faker) {
         return [
            'meal_id' => factory(Meal::class)->id,
            'name' => $faker->name,
        ];
     }
 );

 $factory->define(
     MealToSideItem::class,
     function (Faker\Generator $faker) {
         return [
             'meal_id' => factory(Meal::class)->id,
             'side_item_id' => factory(SideItem::class)->id,
            'name' => $faker->name,
        ];
     }
 );

 $factory->define(
     MealToAllergy::class,
     function () {
         return [
             'meal_id' => factory(Meal::class)->id,
             'allergy_id' => factory(Allergy::class)->id
        ];
     }
 );

 $factory->define(
     UserToAllergy::class,
     function () {
         return [
             'user_id' => factory(User::class)->id,
             'allergy_id' => factory(Allergy::class)->id
        ];
     }
 );
