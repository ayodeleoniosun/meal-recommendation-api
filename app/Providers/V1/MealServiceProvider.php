<?php

namespace App\Providers\V1;

use App\Api\V1\Interfaces\MealInterface;
use App\Api\V1\Repositories\MealRepository;
use Illuminate\Support\ServiceProvider;

class MealServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            MealInterface::class,
            MealRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
