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

	Route::middleware('auth')->group(function(){

		Route::get('add-time', 'TimeSchedulerController@showAddPage')->name('addPage');

		Route::get('edit-time/{id}', 'TimeSchedulerController@showEditPage')->name('editPage');

		Route::resource('connections', 'ConnectionController', ['only' => ['index','update']]);

		Route::resource('time-scheduler', 'TimeSchedulerController', ['only' => ['index','store', 'update', 'destroy']]);

		Route::get('/retrieve-logs', 'TimeSchedulerController@retrieveLogsOnDelete')->name('logs');

		Route::post('video-streaming-url','VideoStreamingUrl@setUrl');

		Route::post('ticker-message','VideoStreamingUrl@setTickerMessage');

		Route::resource('ticker', 'TickerController', ['only' => ['index','store', 'update', 'destroy']]);

		Route::get('add-ticker', 'TickerController@showAddTickerPage')->name('addTickerPage');

		Route::get('edit-ticker/{id}', 'TickerController@showEditTickerPage')->name('editTickerPage');

		Route::get('/retrieve-tickers', 'TickerController@retrieveTickersOnDelete')->name('tickers');

		Route::resource('control-panel', 'ControlPanelController', ['only' => ['index']]);

		Route::get('/fetch-control-panel-view', 'ControlPanelController@fetchControlPanelView')->name('fetchControlPanelView');

		Route::post('add-time-in-control-panel', 'TimeSchedulerController@addTimeInControlPanel');

		Route::post('add-ticker-in-control-panel', 'TickerController@addTickerInControlPanel');

		Route::delete('delete-by-endtime/{id}','TimeSchedulerController@deleteByEndTime');

		Route::get('/fetch-connections-table', 'ConnectionController@fetchConnectionsTable')->name('fetchConnectionsTable');

		Route::patch('close-all-connections','ConnectionController@closeAllConnections');

		Route::get('connections/{macAddress}','ConnectionPerPcController@show');


});
