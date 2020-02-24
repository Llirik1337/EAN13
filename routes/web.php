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


Route::get('/{any?}', function () {
    return view('welcome');
});


Route::prefix('auth')->group(function () {

    Route::post('init', 'AppController@init');
    Route::post('login', 'AppController@login');
    Route::post('logout', 'AppController@loguot');
});

Route::prefix('codeean13')->group(function ()  {
    Route::post('by', 'Codeean13Controller@show');
    Route::get('/', 'Codeean13Controller@index');
    Route::post('add','Codeean13Controller@add');
    Route::post('getStatistics', 'Codeean13Controller@getStatistics');
});

Route::prefix('codedm')->group(function ()  {
    Route::post('by', 'CodedmController@show');
    Route::post('byCode/', 'CodedmController@getByCode');
    Route::post('add','CodedmController@add');
});

Route::prefix('status')->group(function ()  {
    Route::get('set', 'StatusController@store');
});

Route::prefix('admin')->group(function() {
    Route::post('createUser', 'AdminController@createUser');
});

Route::prefix('package')->group(function() {
    Route::post('add', 'PackageController@store');
});

Route::prefix('box')->group(function() {
    Route::post('add', 'BoxController@store');
});

Route::prefix('invoice')->group(function() {
    Route::post('add', 'InvoiceController@store');
    Route::post('get', 'InvoiceController@get');
});
