<?php

use Illuminate\Http\Request;
use App\Fan;
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
  
  Route::post('login', 'API\FanController@login');
  Route::post('register', 'API\FanController@register');
  Route::group(['middleware' => 'auth:api'], function () {
    Route::post('details', 'API\FanController@details');
  });

  Route::get('/news', 'ApiController@getNews')->name('Api.getNews');
  Route::post('predict', 'ApiController@prediction');