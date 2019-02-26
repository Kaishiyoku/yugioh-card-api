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

Route::prefix('v1')->middleware('api')->name('api.')->group(function () {
    Route::get('/health_check', 'Api\v1\HomeController@healthCheck')->name('home.health_check');
    Route::get('/version', 'Api\v1\HomeController@version')->name('home.version');

    Route::get('/cards', 'Api\v1\CardController@index')->name('cards.index');
    Route::get('/cards/search/{title}', 'Api\v1\CardController@search')->name('cards.search');
    Route::get('/cards/from_set/{identifier}', 'Api\v1\CardController@getCardFromSet')->name('cards.get_card_from_set');
    Route::get('/cards/from_set/{identifier}/image', 'Api\v1\CardController@getImage')->name('cards.image');

    Route::get('/sets', 'Api\v1\SetController@index')->name('sets.index');
    Route::get('/sets/search/{term}', 'Api\v1\SetController@search')->name('sets.search');
    Route::get('/sets/{identifier}', 'Api\v1\SetController@show')->name('sets.show');

    Route::Get('/statistics', 'Api\v1\StatisticController@index')->name('statistics.index');
});

Route::fallback(function () {
    return response()->json(['message' => 'Not Found.'], 404);
})->name('api.fallback.404');