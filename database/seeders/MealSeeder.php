<?php

namespace Database\Seeders;

use App\Http\Models\Allergy;
use App\Http\Models\MainItem;
use App\Http\Models\Meal;
use App\Http\Models\MealToAllergy;
use App\Http\Models\MealToSideItem;
use App\Http\Models\SideItem;
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
                
                $sideItems = $sideItems->random(3);
                    
                foreach ($sideItems as $sideItem) {
                    factory(MealToSideItem::class, $count)->create([
                        'meal_id' => $meal->id,
                        'side_item_id' => $sideItem->id
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
