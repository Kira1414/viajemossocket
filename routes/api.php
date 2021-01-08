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

Route::group(['prefix' => 'editoriales','namespace'=>'Api\Editoriales','middleware' => ['auth:api']],function()
{
    Route::get('list', 'EditorialesController@list');
    Route::get('get/{id}', 'EditorialesController@get');
    Route::post('create', 'EditorialesController@create');
    Route::put('update/{id}', 'EditorialesController@update');
    Route::delete('delete/{id}', 'EditorialesController@delete');
});
Route::group(['prefix' => 'autores','namespace'=>'Api\Autores','middleware' => ['auth:api']],function()
{
    Route::get('list', 'AutoresController@list');
    Route::get('get/{id}', 'AutoresController@get');
    Route::post('create', 'AutoresController@create');
    Route::put('update/{id}', 'AutoresController@update');
    Route::delete('delete/{id}', 'AutoresController@delete');
});
Route::group(['prefix' => 'libros','namespace'=>'Api\Libros','middleware' => ['auth:api']],function()
{
    Route::get('list', 'LibrosController@list');
    Route::get('get/{id}', 'LibrosController@get');
    Route::post('create', 'LibrosController@create');
    Route::put('update/{id}', 'LibrosController@update');
    Route::delete('delete/{id}', 'LibrosController@delete');
});
