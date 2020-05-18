<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/api', function () {
    return "Test API routes";
});

Route::group(['namespace' => 'RwandaBuild\MurugoAuth\Http\Controllers'], function () {
    Route::post('/api/murugo-auth', 'AuthenticationController@getMurugoResponse')->name('murugo-auth');
    Route::get('/api/authenticate-user', 'AuthenticationController@authenticateUser')->name('authenticate-user');
    Route::get('/api/logout', 'AuthenticationController@logoutUser')->name('logout');


    //TEST URLS
    Route::get('/api/test-user',function() {
        return \RwandaBuild\MurugoAuth\Facades\MurugoAuth::user();
    })->name('test-user');
});

