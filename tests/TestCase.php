<?php

namespace RwandaBuild\MurugoAuth\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as Orchestra;
use RwandaBuild\MurugoAuth\MurugoAuthServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [MurugoAuthServiceProvider::class];
    }

    protected function defineEnvironment($app)
    {
        // host apps always have an APP_KEY; Testbench has none (needed for the encrypted tokens, F-9)
        $app['config']->set('app.key', 'base64:' . base64_encode(str_repeat('k', 32)));
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', ['driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '']);
        $app['config']->set('cache.default', 'array');
        $app['config']->set('services.murugo', [
            'client_id' => 'client', 'client_secret' => 'secret', 'redirect' => 'https://app.test/callback',
            'murugo_url' => 'https://murugo.test', 'murugo_app_key' => 'app-key', 'disable_user_session' => true,
        ]);
    }

    protected function defineDatabaseMigrations()
    {
        // the package's own migration, as host apps publish it
        $this->loadMigrationsFrom(__DIR__ . '/../src/database/migrations');

        // a host app "users" table that links to murugo_users (MurugoUser::user())
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->unsignedBigInteger('murugo_user_id')->nullable();
            $table->softDeletes(); // in case the app's User model uses SoftDeletes
        });

        if (!class_exists(\App\User::class) && !class_exists(\App\Models\User::class)) {
            eval('namespace App\Models; class User extends \Illuminate\Database\Eloquent\Model { protected $table = "users"; protected $guarded = []; public $timestamps = false; }');
        }
    }

    /** A Murugo /api/thirdparty-me bundle and token response, as the handler passes them on. */
    protected function bundle(string $hashedId, string $name = 'Ana', ?string $globalId = null): array
    {
        $user = ['hashed_murugo_user_id' => $hashedId, 'name' => $name, 'avatar' => null, 'public_name' => $name];
        if ($globalId) {
            $user['murugo_user_id'] = $globalId;
        }

        return [$user, ['access_token' => 'at-' . $name, 'refresh_token' => 'rt-' . $name, 'expires_in' => 3600]];
    }
}
