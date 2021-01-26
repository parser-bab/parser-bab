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
Route::get('/second', 'PersonalCabinetController@second');

//Route::get('/', function () {
//    return view('home');
//});

Route::get('/api', 'ApiController@index');


Route::resource('/list', 'ListController');
Route::get('list/removedata', 'ListController@removedata')->name('list.removedata');



Route::resource('/apis', 'ApiEndController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
