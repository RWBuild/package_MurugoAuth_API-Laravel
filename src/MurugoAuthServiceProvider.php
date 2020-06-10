<?php

/**
 * Created by PhpStorm.
 * User: Uwe Aime Van
 * Date: 4/28/2020
 * Time: 12:18 PM
 */

namespace RwandaBuild\MurugoAuth;

use Illuminate\Support\ServiceProvider;
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
        $this->app->bind('MurugoAuth', AuthenticationController::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations/2020_06_05_141302_remove_email_from_murugo_users.php');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations/2020_06_10_103958_create_murugo_one_time_tokens_table.php');
        $this->publishes([
            __DIR__ . '/database/migrations/' => database_path('migrations')
        ], 'migrations');
    }
}
