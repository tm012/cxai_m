<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('insert_query_api','QAController@insert_query_api');
//https://medium.com/@ujalajha/restful-api-in-laravel-5c1389c58ca0
//https://www.toptal.com/laravel/restful-laravel-api-tutorial