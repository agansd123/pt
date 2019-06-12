<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {

        //默认令牌发放的有效期是永久
        //Passport::tokensExpireIn(Carbon::now()->addDays(2));
        //Passport::refreshTokensExpireIn(Carbon::now()->addDays(4));

        $this->registerPolicies();

        Passport::routes();
        //
    }
}
