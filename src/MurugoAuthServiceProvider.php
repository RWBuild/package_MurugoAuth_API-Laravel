<?php

/**
 * Created by PhpStorm.
 * User: Uwe Aime Van
 * Date: 4/28/2020
 * Time: 12:18 PM
 */

namespace RwandaBuild\MurugoAuth;

use Illuminate\Support\ServiceProvider;
use RwandaBuild\MurugoAuth\MurugoAuthHandler;

class MurugoAuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('MurugoAuth', MurugoAuthHandler::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/database/migrations/' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/rwandabuild/murugo_api_auth/'),
        ], 'murugo-public');

        $this->loadViewsFrom(__DIR__ . '/views/murugo', 'murugo');

        $this->loadRoutesFrom(__DIR__ . '/routes/v1/web.php');
    }
}
