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

Route::group(['middleware' => ['cors', 'json.response']], function () {

  Route::post('/register', 'App\Http\Controllers\Api\AuthController@register');
  Route::post('/login', 'App\Http\Controllers\Api\AuthController@login');
  Route::apiResource('/ceo', 'App\Http\Controllers\Api\CEOController')->middleware('auth:api');

  Route::get('/pages_front', 'App\Http\Controllers\PageController@index');
  Route::get('/texts_front', 'App\Http\Controllers\TextController@index');



  //backoffice

  //pages
  Route::middleware(['role:super-admin','auth:api'])->get('pages', 'App\Http\Controllers\PageController@index');
  Route::middleware(['role:super-admin','auth:api'])->get('pages/{id}', 'App\Http\Controllers\PageController@show');
  Route::middleware(['role:super-admin','auth:api'])->post('pages', 'App\Http\Controllers\PageController@store');
  Route::middleware(['role:super-admin','auth:api'])->put('pages/{id}', 'App\Http\Controllers\PageController@update');
  Route::middleware(['role:super-admin','auth:api'])->delete('pages/{id}', 'App\Http\Controllers\PageController@destroy');

  //texts
  Route::middleware(['role:super-admin','auth:api'])->get('texts', 'App\Http\Controllers\TextController@index');
  Route::middleware(['role:super-admin','auth:api'])->get('texts/{id}', 'App\Http\Controllers\TextController@show');

  Route::middleware(['role:super-admin','auth:api'])->post('texts', 'App\Http\Controllers\TextController@store');
  Route::middleware(['role:super-admin','auth:api'])->put('texts/{id}', 'App\Http\Controllers\TextController@update');
  Route::middleware(['role:super-admin','auth:api'])->delete('texts/{id}', 'App\Http\Controllers\TextController@destroy');


  //langues
  Route::get('langues', 'App\Http\Controllers\LangueController@index');
  Route::get('langues/{id}', 'App\Http\Controllers\LangueController@show');
  Route::middleware(['role:super-admin','auth:api'])->post('langues', 'App\Http\Controllers\LangueController@store');
  Route::middleware(['role:super-admin','auth:api'])->put('langues/{id}', 'App\Http\Controllers\LangueController@update');
  Route::middleware(['role:super-admin','auth:api'])->delete('langues/{id}', 'App\Http\Controllers\LangueController@destroy');



});
