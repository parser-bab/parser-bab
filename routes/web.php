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
Route::post('/setpisal', 'GirlController@setPisal');
Route::post('/setwrite', 'GirlController@setWrite');

Route::post('/setpisalmusic', 'GirlController@setPisalMusic');
Route::post('/setwritemusic', 'GirlController@setWriteMusic');



Route::get('/', 'PersonalCabinetController@index')->name('PersonalCabinet');
Route::get('/indexByDateMusic', 'ListController@indexByDateMusic')->name('indexByDateMusic');
Route::get('/indexNormMusic', 'ListController@indexNormMusic')->name('indexNormMusic');
Route::get('/indexByCountMusic', 'ListController@indexByCount')->name('indexByCount');
Route::get('/indexMusicAll', 'ListController@indexMusicAll')->name('indexMusicAll');

Route::get('/create-task', 'PersonalCabinetController@createTask')->name('PersonalCabinetCreateTask');
Route::post('/create-task', 'PersonalCabinetController@storeTask')->name('PersonalCabinetStoreTask');
Route::post('/check-task', 'PersonalCabinetController@checkTask');


Route::get('/create-music', 'PersonalCabinetController@createMusic')->name('PersonalCabinetCreateMusic');
Route::get('/create-music/{music}', 'PersonalCabinetController@showMusic')->name('PersonalCabinetShowMusic');
Route::post('/store-music', 'PersonalCabinetController@storeMusic')->name('PersonalCabinetStoreMusic');


Route::resource('/application', 'ApplicationController');
Route::get('/application/{application}', 'ApplicationController@writeId')->name('ApplicationWriteId');
Route::post('/resetapplication', 'ApplicationController@resetCount')->name('ApplicationResetCount');


Route::get('/second', 'ApplicationController@getToken');
//Route::get('/', function () {
//    return view('home');
//});

Route::get('/api', 'ApiController@index');


Route::resource('/list', 'ListController');
Route::get('/listnorm', 'ListController@indexNorm')->name('list.indexNorm');
Route::get('/listdate', 'ListController@indexByDate')->name('list.indexByDate');


Route::resource('/girl', 'GirlController');
Route::get('/online', 'GirlController@online')->name('girl.online');
Route::get('/online/update', 'GirlController@updateOnline')->name('girl.update.online');
Route::post('/deletegirl', 'ListController@destroyApi');
Route::post('/deletegirlmusic', 'ListController@destroyApiMusic');

Route::resource('/task', 'TaskController');
Route::get('list/removedata', 'ListController@removedata')->name('list.removedata');

Route::get('/logs-job','PersonalCabinetController@logs')->name('job.logs');
Route::delete('/clear-job','PersonalCabinetController@clearJob')->name('job.clear');


Route::resource('/apis', 'ApiEndController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get ('/pizdec', 'PersonalCabinetController@fix');

Route::get('/music', 'PersonalCabinetController@indexMusic')->name('music');

Route::post('/findgirl', 'GirlController@findGirl');
Route::get('/findgirl', 'PersonalCabinetController@findGirl')->name('findGirl');
