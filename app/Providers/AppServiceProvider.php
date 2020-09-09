<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Singleton\RestUrl;

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
