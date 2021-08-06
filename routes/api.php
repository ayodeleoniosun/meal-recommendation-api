<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(
    ['prefix' => 'v1', 'namespace' => 'App\Api\V1\Controllers'],
    function () {
        Route::group(['prefix' => 'accounts'], function () {
            Route::post('/register', 'UserController@register')->name('accounts.register');
            Route::post('/login', 'UserController@login')->name('accounts.login');
        });
    }
);
