<?php
/**
 * Created by PhpStorm.
 * User: Uwe Aime Van
 * Date: 4/28/2020
 * Time: 12:18 PM
 */

namespace RwandaBuild\MurugoAuth;

use Illuminate\Support\ServiceProvider;

class MurugoAuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }
}
