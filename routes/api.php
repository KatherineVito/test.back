<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(["middleware" => "apikey.validate"], function() {
    Route::post('dni','App\Http\Controllers\DniController@store');
    Route::post('certipeid', 'App\Http\Controllers\CertipeidController@store');
    Route::get('check_exist/{dni_number}','App\Http\Controllers\DniController@checkValidDni');
    Route::get('dni_information_pet/{dni_number_pet}','App\Http\Controllers\DniController@show');
});

//Route::get('all_dni/{hash}','App\Http\Controllers\DniController@showAll');
//Route::get('dni/{dni_number_pet}','App\Http\Controllers\DniController@show');

Route::get('dni_front/{dni_number}','App\Http\Controllers\DniController@getDniFront');
Route::get('dni_back/{dni_number}','App\Http\Controllers\DniController@getDniBack');
//Route::get('dni_back/{dni_hash_id}/{dni_number}','App\Http\Controllers\DniController@getDniBackHash');
//Route::delete('dni/delete/{dni_number}/{hash}','App\Http\Controllers\DniController@deleteDnibyNumberAndHash');


Route::get('certipeid/{dni_number}','App\Http\Controllers\CertipeidController@getCertipeid');
Route::get('qr/{dni_number}','App\Http\Controllers\DniController@getQrCode');
Route::get('download_image/{dni_number}','App\Http\Controllers\DniController@getImage');
//Route::get('certipeid/{cellphone_owner}','App\Http\Controllers\CertipeidController@show');

Route::get('download/{type_of_photo}/{dni_number}','App\Http\Controllers\DniController@downloadImage');

//Route::get('dnihash/{dni_number}','App\Http\Controllers\DniController@getHashByDniNumber');
