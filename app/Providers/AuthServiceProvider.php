<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define($ability = 'isAdmin', function ($user) {
            return $user->privilage === 'admin';
        });

        Gate::define($ability = 'isManager', function ($user) {
            return $user->privilage === 'manager';
        });

        Gate::define($ability = 'isCustomer', function ($user) {
            return $user->privilage === 'customer';
        });
    }
}
