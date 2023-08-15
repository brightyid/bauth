<?php

namespace Brighty\BAuth;

use Brighty\BAuth\Console\InstallBAuth;
use Brighty\BAuth\Http\Middleware\BAuthenticated;
use Illuminate\Support\ServiceProvider;

class BAuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/bauth.php', 'bauth');

        $this->app->bind('bauth', function ($app) {
            return new BAuth();
        });
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/bauth.php' => 'config/bauth.php'
            ], 'config');
            $this->commands([
                InstallBAuth::class,
            ]);
        }

        $this->app['router']->aliasMiddleware('bauth', BAuthenticated::class);
    }
}
