<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
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

    Route::group(['middleware' => 'prevent-back-history'],function() {
        Auth::routes();
        Route::group(['prefix' => 'admin', 'as' => 'admin'], function() {
        Route::get('/', 'App\Http\Controllers\AdminController@index');
        Route::get('/reports', 'App\Http\Controllers\AdminController@getDniData');
        Route::delete('/dni/delete/{id}', 'App\Http\Controllers\AdminController@deleteDniData');
        Route::post('/dni/edit', 'App\Http\Controllers\AdminController@editDniData');
        Route::get('/dni/imprimir', 'App\Http\Controllers\AdminController@printAllDnis');
        Route::get('/dni/csv', 'App\Http\Controllers\AdminController@getDnisCsv4');
        Route::resource('/usuarios','App\Http\Controllers\UsersController');
        Route::post('/usuarios/edit','App\Http\Controllers\UsersController@editUser');
        //Route::get('searchYourBreed/{id}');
        
        Route::resource('dnis',AdminController::class);
        //Route::get('searchYourBreed',[AdminController::class, 'searchYourBreed'])->name('searchYourBreed');
        Route::get('searchYourBreed/{id}', 'App\Http\Controllers\AdminController@searchYourBreed')->name('searchYourBreed');
        Route::get('/html-pdf', 'App\Http\Controllers\AdminController@pdfLoadView');
        Route::get('/downloadpdf','App\Http\Controllers\AdminController@downloadPdfView')->name('downloadpdf');
    });
        
    });

    Route::post('subcategoria','App\Http\Controllers\AdminController@searchYourBreed')->name('subcategoria');
