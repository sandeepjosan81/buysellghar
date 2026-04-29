<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\File;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $pluginPath = base_path('plugins');

        foreach (glob($pluginPath . '/*', GLOB_ONLYDIR) as $plugin) {

            $provider = 'Plugins\\' . basename($plugin) . '\\PluginServiceProvider';

            if (class_exists($provider)) {
                $this->app->register($provider);
            } else {
                // dump('Class not found: ' . $provider);
            }
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        if (env('APP_FORCE_HTTPS', false)) {
            URL::forceScheme('https');
        }
    }
}
