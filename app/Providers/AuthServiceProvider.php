<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        if (! $this->app->routesAreCached()) {
            Passport::routes();
        }
        Passport::tokensExpireIn(now()->addDay());
        Passport::refreshTokensExpireIn(now()->addDay());
        Passport::personalAccessTokensExpireIn(now()->addDay());

        Gate::define('product-full', function () {
            if (auth()->user()->id == 1) return true;
            return auth()->user()->product_permission === 2;
        });

        Gate::define('product-show', function () {
            if (auth()->user()->id == 1) return true;
            return auth()->user()->product_permission > 0;
        });

        Gate::define('special-full', function () {
            if (auth()->user()->id == 1) return true;
            return auth()->user()->special_permission === 2;
        });

        Gate::define('special-show', function () {
            if (auth()->user()->id == 1) return true;
            return auth()->user()->special_permission > 0;
        });

        Gate::define('domain-full', function () {
            if (auth()->user()->id == 1) return true;
            return auth()->user()->domain_permission === 2;
        });

        Gate::define('domain-show', function () {
            if (auth()->user()->id == 1) return true;
            return auth()->user()->domain_permission > 0;
        });
    }
}
