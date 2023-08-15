<?php

namespace Brighty\BAuth;

use Illuminate\Support\ServiceProvider;

class BAuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/bauth.php', 'bauth');
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/config/bauth.php' => config_path('bauth.php'),
            ], 'config');
        }
    }
}
