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

// use Illuminate\Routing\Route;

// use Illuminate\Routing\Route;

Route::get('/{any?}', function () {
    return view('welcome');
});


Route::prefix('auth')->group(function () {

    Route::get('init', 'AppController@init');

    Route::post('login', 'AppController@login');
    Route::post('logout', 'AppController@loguot');
});

Route::prefix('codeean13')->group(function ()  {
    Route::get('by/{code}', 'Codeean13Controller@show');
    Route::get('/', 'Codeean13Controller@index');
    Route::post('add','Codeean13Controller@add');
});

Route::prefix('codedm')->group(function ()  {
    Route::get('by/{codeean13_id}', 'CodedmController@show');
    Route::post('byCode/', 'CodedmController@getByCode');
    Route::post('add','CodedmController@add');
});

Route::prefix('status')->group(function ()  {
    Route::get('set', 'StatusController@store');
});
