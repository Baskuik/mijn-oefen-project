<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * De policy mappings voor de applicatie.
     */
    protected $policies = [
        //
    ];

    /**
     * Registreer authenticatie / autorisatie diensten.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}