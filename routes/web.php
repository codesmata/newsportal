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

Route::get('/', 'NewsController@index');

Route::get('/home', 'HomeController@index')->name('home');

$excludeRoutes = ['except' => ['edit', 'update']];
Route::resource('/news', 'NewsController', $excludeRoutes);

Route::get('user-news', 'NewsController@getUserNews');

Auth::routes();

Route::get('/success', 'Auth\RegisterController@success')->name('success');

Route::get('/verify/{email}', 'Auth\VerificationController@verify')->name('verify-email');

Route::post('/verify/{email}/create-password', 'Auth\VerificationController@createPassword');

Route::get('rss-feed', 'NewsController@generateNewsFeed');

Route::get('photos/{photo}', function ($photo) {
    $path = storage_path().'/app/test-images/' . $photo;
    if (file_exists($path)) {
        return Response::download($path);
    }
});