<?php

namespace Blink;

use Illuminate\Support\ServiceProvider;

class BlinkServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/blink.php', 'blink'
        );
        $this->app->singleton('blink', function () {
            return new Blink;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
        
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/blink.php' => config_path('blink.php')
            ],'blink-config');
        }
    }
}
