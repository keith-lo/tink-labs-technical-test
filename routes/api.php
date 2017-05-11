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

/*
    Version : 1.0
    Url prefix: /api/1.0/xxxxx
*/
Route::group(['prefix' => '1.0'], function(){

    Route::resource('account', 'AccountController', ['only' => [
        'index', 'show', 'create', 'destroy'
    ]]);

    Route::resource('transaction', 'TransactionController', ['only' => [
        'index', 'show', 'create', 'transfer'
    ]]);

    Route::post('transaction/transfer', 'TransactionController@transfer');


});