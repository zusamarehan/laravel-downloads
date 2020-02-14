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


Route::get('/projects', 'ProjectController@index');
Route::get('/projects/{project}', 'ProjectController@show');

Route::get('/export', 'ExportController@export');
Route::get('/export/status/{downloadRequests}', 'ExportController@status')->name('exportStatus');
Route::get('/export/status/percentage/{downloadRequests}', 'ExportController@percentage')->name('exportStatus');
Route::get('/export/download/{downloadRequests}', 'ExportController@download');
