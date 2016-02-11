<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', function () {
    return view('start');
});

Route::post('/auth/register','Auth\AuthController@register');
Route::post('/auth/login','Auth\AuthController@login');*/
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get('/', 'GuestController@open');
    Route::get('/home', 'GuestController@home');
    //Route::post('password/email', 'Auth\PasswordController@postEmail');
    Route::post('/auth/register','Auth\AuthController@register');
    Route::post('/auth/login','Auth\AuthController@login');
    Route::get('/dashboard','HomeController@dashboard');
    Route::get('/auth/logout', 'Auth\AuthController@logout');
    Route::controllers([
        'password' => 'Auth\PasswordController',
    ]);
});
