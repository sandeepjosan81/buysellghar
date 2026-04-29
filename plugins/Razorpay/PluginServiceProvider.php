<?php

namespace Plugins\Razorpay;

use Illuminate\Support\ServiceProvider;

class PluginServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->loadViewsFrom(__DIR__ . '/views', 'razorpay');
        $this->mergeConfigFrom(__DIR__ . '/config.php', 'razorpay');

        
    }

    public function register()
    {
       
    }
    
}