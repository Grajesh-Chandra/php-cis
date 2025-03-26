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
                'privateKey' => "-----BEGIN ENCRYPTED PRIVATE KEY-----\n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\n-----END ENCRYPTED PRIVATE KEY-----\n",
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
