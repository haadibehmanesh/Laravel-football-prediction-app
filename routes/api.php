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

  Route::post('/news', 'ApiController@getNews')->name('Api.getNews');
  Route::post('/othernews', 'ApiController@otherNews')->name('Api.otherNews');
  Route::post('/newsaddlike', 'ApiController@addLikeNews')->name('Api.addLikeNews');
  Route::post('/newsdeletelike', 'ApiController@deleteLikeNews')->name('Api.deleteLikeNews');
  Route::post('/gallery', 'ApiController@fetchGallery')->name('Api.fetchGallery');
  Route::post('/teamstandings', 'ApiController@fetchTeams')->name('Api.fetchTeams');
  Route::post('predict', 'ApiController@prediction');
  Route::post('userinfo', 'ApiController@fetchUserInfo');
  Route::post('uploadimage', 'ApiController@uploadProfileImage');

  Route::post('predictProfile', 'ApiController@fetchPredictedGames');
  Route::post('games', 'ApiController@fetchGames');
  Route::post('currentgames', 'ApiController@fetchCurrentgames');
  Route::post('topusers', 'ApiController@fetchTopUsers');
  Route::post('topusersweek', 'ApiController@fetchTopWeek');
  Route::post('topusersseason', 'ApiController@fetchTopSeason');
  Route::post('newsdetail', 'ApiController@newsDetail');
  Route::post('search', 'ApiController@fetchSearch');
