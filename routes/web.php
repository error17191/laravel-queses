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
    dispatch(new \App\Jobs\LogSomething());

    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/user/settings', 'UserSettingsController@edit')->name('edit_user_settings_form');
Route::put('/user/settings', 'UserSettingsController@update')->name('update_user_settings');


Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
