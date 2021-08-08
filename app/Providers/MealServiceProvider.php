<?php

namespace App\Providers;

use App\Http\Interfaces\MealInterface;
use App\Http\Repositories\MealRepository;
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
