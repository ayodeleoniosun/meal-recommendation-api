<?php

namespace App\Providers;

use App\Http\Interfaces\AllergyInterface;
use App\Http\Repositories\AllergyRepository;
use Illuminate\Support\ServiceProvider;

class AllergyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            AllergyInterface::class,
            AllergyRepository::class
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
