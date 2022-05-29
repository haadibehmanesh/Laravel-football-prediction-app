<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', function () {
  return view('comingsoon::comingsoon');
});


Route::group(['prefix' => 'admin'], function () {
 
  Route::get('posts/league-calendars','Voyager\ValidatePredictionController@validatePrediction')->name('league-calendars.validatePrediction');
    Voyager::routes();
});

Route::group(['prefix' => 'fan'], function () {
  Route::get('/login', 'FanAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'FanAuth\LoginController@login');
  Route::post('/logout', 'FanAuth\LoginController@logout')->name('logout');

  Route::get('/register', 'FanAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'FanAuth\RegisterController@register');

  Route::post('/password/email', 'FanAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'FanAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'FanAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'FanAuth\ResetPasswordController@showResetForm');
});
