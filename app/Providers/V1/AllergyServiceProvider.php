<?php

namespace App\Providers\V1;

use App\Api\V1\Interfaces\AllergyInterface;
use App\Api\V1\Repositories\AllergyRepository;
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
