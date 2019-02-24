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

Route::prefix('v1')->middleware('api')->group(function () {
    Route::get('/health_check', 'Api\v1\HomeController@healthCheck');
    Route::get('/version', 'Api\v1\HomeController@version');

    Route::get('/cards', 'Api\v1\CardController@index');
    Route::get('/cards/search/{title}', 'Api\v1\CardController@search');
    Route::get('/cards/from_set/{identifier}', 'Api\v1\CardController@getCardFromSet');

    Route::get('/sets', 'Api\v1\SetController@index');
    Route::get('/sets/search/{term}', 'Api\v1\SetController@search');
});

Route::fallback(function () {
    return response()->json(['message' => 'Not Found.'], 404);
})->name('api.fallback.404');