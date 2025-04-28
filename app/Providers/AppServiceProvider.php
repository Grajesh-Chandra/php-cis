<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\Factory;
use AffinidiTdk\AuthProvider\AuthProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //Register Affinidi AuthProvider as singleton
        $this->app->singleton(AuthProvider::class, function ($app) {
            $params = [
                'privateKey' => config('services.affinidi_tdk.private_key'),
                'keyId' => config('services.affinidi_tdk.key_id'),
                'passphrase' => config('services.affinidi_tdk.passphrase'),
                'projectId' => config('services.affinidi_tdk.project_Id'),
                'tokenId' => config('services.affinidi_tdk.token_id'),
            ];

            return new AuthProvider($params);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $socialite = $this->app->make(Factory::class);

        //Setup affinidi driver
        \Affinidi\SocialiteProvider\AffinidiSocialite::extend($socialite);
    }
}
