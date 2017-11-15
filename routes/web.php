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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', 'mainController@index');
Route::get('/month/{companyID}', 'mainController@month')->name('month');
Route::get('/summary/{summaryID}',  'mainController@summary')->name('summary');
Route::get('/summary/{summaryID}/place/{place}',  'mainController@summary')->name('summaryPlace');

Route::post('/month/{companyID}', 'mainController@addSummary');
Route::post('/summary/{summaryID}',  'mainController@summaryDataAdd')->name('summaryDataAdd');
//Route::post('/', 'mainController@createExcel');