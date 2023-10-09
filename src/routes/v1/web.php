<?php

use RwandaBuild\MurugoAuth\Facades\MurugoAuth;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'auth', 'middleware' => 'web'], function () {
    Route::get('/redirect', function () {
        return MurugoAuth::redirect();
    })->name('redirect');
});
