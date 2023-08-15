<?php

namespace Brighty\BAuth;

use Brighty\BAuth\Http\Middleware\BAuthenticated;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

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
                __DIR__ . '/../config/bauth.php' => config_path('bauth.php'),
            ], 'config');
        }

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('bauth', BAuthenticated::class);
    }
}
