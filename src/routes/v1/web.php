<?php

use RwandaBuild\MurugoAuth\Facades\MurugoAuth;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'auth', 'middleware' => 'web'], function () {
    Route::get('/murugo/redirect', function () {
        return MurugoAuth::redirect();
    })->name('murugo.auth.redirect');
});
