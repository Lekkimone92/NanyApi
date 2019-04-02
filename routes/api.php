<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::apiResource('/areas', 'AreaController');

    Route::group(['prefix' => 'users'], function (){
        Route::apiResource('/{user}/areas', 'UsersAreaController');
    });

    Route::get('users/children', 'UserController@children');
    Route::get('areas/{child_id}/get_areas', 'AreaController@getAreas');

    Route::post('users/add_photo', 'UserController@addPhoto');
    Route::get('users/{id}/show_image', 'UserController@showImage');
    Route::post('users/add_child_photo', 'UserController@addChildPhoto');
    Route::post('users/add_child', 'UserController@addChild');
    Route::post('areas/add_area', 'AreaController@addArea');
    Route::post('logout', 'LoginController@logout');
});


//Route::apiResource('/users', 'UserController');
Route::post('users/register', 'UserController@register');


Route::post('users/login', 'LoginController@login');
Route::post('users/refresh', 'LoginController@refresh');