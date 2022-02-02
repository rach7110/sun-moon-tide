<?php

namespace App\Providers;

use App\Contracts\ClimateServiceContract;
use App\Service\SunMoon\SunMoonService;
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
