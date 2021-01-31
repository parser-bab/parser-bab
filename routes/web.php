<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'PersonalCabinetController@index')->name('PersonalCabinet');
Route::get('/second', 'PersonalCabinetController@getToken');
Route::get('/create-task', 'PersonalCabinetController@createTask')->name('PersonalCabinetCreateTask');
Route::post('/create-task', 'PersonalCabinetController@storeTask')->name('PersonalCabinetStoreTask');

//Route::get('/', function () {
//    return view('home');
//});

Route::get('/api', 'ApiController@index');


Route::resource('/list', 'ListController');
Route::resource('/girl', 'GirlController');
Route::resource('/task', 'TaskController');
Route::get('list/removedata', 'ListController@removedata')->name('list.removedata');

Route::get('/logs-job','PersonalCabinetController@logs')->name('job.logs');
Route::delete('/clear-job','PersonalCabinetController@clearJob')->name('job.clear');


Route::resource('/apis', 'ApiEndController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
