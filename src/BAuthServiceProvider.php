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
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallBAuth::class,
            ]);
        }
    }
}
