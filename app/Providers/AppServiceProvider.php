<?php

namespace App\Providers;

use App\Contracts\Services\ClientService;
use App\Contracts\Services\CouponService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        $this->app->register(\App\Providers\RepositoryServiceProvider::class);

        $this->app->singleton(ClientService::class, function ($app) {
            return new \App\Services\ClientService();
        });

        $this->app->singleton(CouponService::class, function ($app) {
            return new \App\Services\CouponService();
        });
    }
}
