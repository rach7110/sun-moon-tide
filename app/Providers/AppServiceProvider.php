<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\ClimateServiceContract;
use App\Service\SolunarService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ClimateServiceContract::class, SolunarService::class);
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
