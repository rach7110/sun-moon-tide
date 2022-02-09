<?php

namespace App\Providers;

use App\Contracts\ClimateServiceContract;
use App\Contracts\TideServiceContract;
use App\Service\SunMoon\SolunarService;
use App\Service\Tide\NoaaTidalService;
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
        $this->app->bind(TideServiceContract::class, NoaaTidalService::class);
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
