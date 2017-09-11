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

Route::get('/', function () {
    return view('welcome');
});

$excludeRoutes = ['except' => ['edit', 'update']];
Route::resource('/news', 'NewsController', $excludeRoutes);

Auth::routes();

Route::get('/success', 'Auth\RegisterController@success')->name('success');

Route::get('/verify/{email}', 'Auth\VerificationController@verify')->name('verify-email');
Route::post('/verify/{email}/create-password', 'Auth\VerificationController@createPassword');

Route::get('/home', 'HomeController@index')->name('home');
