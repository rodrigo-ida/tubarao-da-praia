<?php

namespace App\Providers;

use App\Auth\LoginTokenGuard;
use App\Auth\LoginTokenUserProvider;
use function foo\func;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin', function ($user) {
            return $user->role == \App\User::ROLE_ADMIN;
        });

        Gate::define('loja', function ($user) {
            return $user->role == \App\User::ROLE_LOJA;
        });

        Gate::define('cliente', function ($user) {
            return $user->role == \App\User::ROLE_USER;
        });

        Gate::define('entregador', function ($user) {
            return $user->role == \App\User::ROLE_DELIVERYMAN;
        });

        Auth::extend('logintoken', function ($app, $name, array $config) {

            $guard = new LoginTokenGuard('logintoken', Auth::createUserProvider($config['provider']), $this->app['session.store']);

            if (method_exists($guard, 'setCookieJar')) {
                $guard->setCookieJar($this->app['cookie']);
            }

            if (method_exists($guard, 'setDispatcher')) {
                $guard->setDispatcher($this->app['events']);
            }

            if (method_exists($guard, 'setRequest')) {
                $guard->setRequest($this->app->refresh('request', $guard, 'setRequest'));
            }

            return $guard;
        });
    }
}
