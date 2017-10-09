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

Route::get('/', function() {
	return view('login.login');
});

Auth::routes();

	Route::group(array('prefix' => '', 'before' => 'auth'), function() {

	Route::get('time-scheduler/add-time', 'TimeSchedulerController@showAddPage')->name('addPage');

	Route::get('time-scheduler/edit-time/{id}', 'TimeSchedulerController@showEditPage')->name('editPage');

	Route::resource('time-scheduler', 'TimeSchedulerController', ['only' => ['index','store', 'update', 'destroy']]);

	Route::get('/home', 'HomeController@index')->name('home');

	Route::post('video-streaming-url','VideoStreamingUrl@setUrl');

});
