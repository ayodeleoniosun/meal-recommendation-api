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

        Route::group(['prefix' => 'users', 'middleware' => ['v1.authenticate.user']], function () {
            Route::get('/my-allergies', 'AllergyController@myAllergies')->name('users.allergies.index');
            Route::post('/allergies', 'AllergyController@pickAllergies')->name('users.allergies.pick');
        });

        Route::group(['prefix' => 'meals'], function () {
            Route::get('/', 'MealController@index')->name('meals.index');
            Route::get('/{id}', 'MealController@show')->name('meals.show');
        });
    }
);
