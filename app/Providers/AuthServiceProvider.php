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
        'App\Models\Dossier' => 'App\Policies\DossierPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function($user, $permission)
        {   
            //echo $user->isAdministrator() ;
            if ($user->isAdministrator()) {
                return true ;
            }
                 

        });

        Gate::after(function($user, $permission)
        {   
            //echo $user->permissions()->contains($permission);

            if ($user->permissions()->contains($permission))
            {
                return true ;
            }
        });
    }
}
