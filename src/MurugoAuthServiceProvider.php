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
use RwandaBuild\MurugoAuth\Http\Controllers\AuthenticationController;

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
    }
}
