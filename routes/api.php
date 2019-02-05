<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::apiResource('/areas', 'AreaController');

    Route::group(['prefix' => 'users'], function (){
        Route::apiResource('/{user}/areas', 'UsersAreaController');
    });

    Route::post('logout', 'LoginController@logout');
});


//Route::apiResource('/users', 'UserController');

Route::post('users/register', 'UserController@register');


Route::post('users/login', 'LoginController@login');
Route::post('users/refresh', 'LoginController@refresh');