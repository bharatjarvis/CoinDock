<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Laravel\Passport\AuthCode;
use Laravel\Passport\Client;
use Laravel\Passport\PersonalAccessClient;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
        
        Passport::useClientModel(Client::class);
        Passport::useAuthCodeModel(AuthCode::class);
        Passport::usePersonalAccessClientModel(PersonalAccessClient::class);

        Passport::tokensExpireIn(now()->addDays(config('passport.tokens_expire_in')));
        Passport::refreshTokensExpireIn(now()->addDays(config('passport.personal_access_tokens_expire_in')));
        Passport::personalAccessTokensExpireIn(now()->addMonths(config('passport.refresh_tokens_expire_in')));
        Passport::tokensCan(config('passport.scopes'));
        
    }
}