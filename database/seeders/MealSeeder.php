<?php

namespace Database\Seeders;

use App\Api\V1\Models\Allergy;
use App\Api\V1\Models\MainItem;
use App\Api\V1\Models\Meal;
use App\Api\V1\Models\MealToAllergy;
use App\Api\V1\Models\MealToSideItem;
use App\Api\V1\Models\SideItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = 1;
        $allergies = Allergy::all();
        $meals = factory(Meal::class, 50)->create();
        $sideItems = factory(SideItem::class, 5)->create();

        DB::transaction(function () use ($meals, $allergies, $sideItems, $count) {
            foreach ($meals as $meal) {
                factory(MainItem::class, 1)->create([
                    'meal_id' => $meal->id
                ]);

                foreach ($sideItems as $side_item) {
                    factory(MealToSideItem::class, $count)->create([
                        'meal_id' => $meal->id,
                        'side_item_id' => $side_item->id
                    ]);
                }

                foreach ($allergies as $allergy) {
                    factory(MealToAllergy::class, $count)->create([
                        'meal_id' => $meal->id,
                        'allergy_id' => $allergy->id
                    ]);
                }
            }
        });
    }
}
