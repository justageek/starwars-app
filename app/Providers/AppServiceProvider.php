<?php

namespace App\Providers;

use App\Services\StarWarsService;
use App\Services\StarWarsApiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(StarWarsApiService::class, function () {
            return new StarWarsApiService();
        });

        $this->app->singleton(StarWarsService::class, function ($app) {
            $api = $app->make(StarWarsApiService::class);
            return new StarWarsService($api);
        });


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
