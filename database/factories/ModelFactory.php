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

use App\Http\Models\Allergy;
use App\Http\Models\MainItem;
use App\Http\Models\Meal;
use App\Http\Models\MealToAllergy;
use App\Http\Models\MealToSideItem;
use App\Http\Models\SideItem;
use App\Http\Models\User;
use App\Http\Models\UserToAllergy;
use App\Helper;

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
            'email_address' => $faker->unique()->safeEmail,
            'password' => bcrypt('secret')
        ];
     }
 );


 $factory->define(
     MainItem::class,
     function (Faker\Generator $faker) {
         return [
            'meal_id' => $faker->randomDigit,
            'name' => $faker->name,
        ];
     }
 );

 $factory->define(
     MealToSideItem::class,
     function (Faker\Generator $faker) {
         return [
             'meal_id' => $faker->randomDigit,
             'side_item_id' => $faker->randomDigit,
        ];
     }
 );

 $factory->define(
     MealToAllergy::class,
     function (Faker\Generator $faker) {
         return [
             'meal_id' => $faker->randomDigit,
             'allergy_id' => $faker->randomDigit
        ];
     }
 );

 $factory->define(
     UserToAllergy::class,
     function (Faker\Generator $faker) {
         return [
             'user_id' => $faker->randomDigit,
             'allergy_id' => $faker->randomDigit
        ];
     }
 );
