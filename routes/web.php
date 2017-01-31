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

Route::get('/',  ['as' => 'admin.urlshot.index', 'uses' => 'ScreenshotController@index']); 
Route::post('/process', ['as' => 'admin.urlshot.process', 'uses' => 'ScreenshotController@process']); 
Route::get('/allWidgets', ['as' => 'admin.urlshot.allWidgets', 'uses' => 'ScreenshotController@allWidgets']); 