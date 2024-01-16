<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Singleton\RestUrl;
use App\Singleton\RestCurrency;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('RestUrl', function ($app) {
            return new RestUrl($app);
        });
        $this->app->singleton('RestCurrency', function ($app) {
            return new RestCurrency($app);
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
