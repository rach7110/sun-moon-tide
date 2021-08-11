<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\ClimateProviderContract;
use App\ThirdPartyApi\Solunar;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ClimateProviderContract::class, Solunar::class);
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
