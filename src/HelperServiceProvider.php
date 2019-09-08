<?php

namespace Fikrimi\LaravelHelper;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //$this->loadRoutesFrom(__DIR__ . '/routes.php');
        //$this->loadMigrationsFrom(__DIR__ . '/Databases/migrations');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__ . '/GeneralHelper.php';
        include __DIR__ . '/ArbitraryHelper.php';
        include __DIR__ . '/UrlHelper.php';
        include __DIR__ . '/StringHelper.php';
        include __DIR__ . '/FormHelper.php';
    }
}
