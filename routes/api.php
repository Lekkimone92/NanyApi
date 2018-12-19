<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('/users', 'UserController');
Route::apiResource('/areas', 'AreaController');

Route::group(['prefix' => 'users'], function (){
    Route::apiResource('/{user}/areas', 'UsersAreaController');
});