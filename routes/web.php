<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
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



Route::post('/register', 'ApiUserController@create');
Route::post('/login', 'ApiUserController@show');

Route::get('/domains', 'DomainController@index');
Route::get('/domain/{id?}', 'DomainController@show');
Route::post('/domain/', 'DomainController@create');
Route::put('/domain/{id?}', 'DomainController@update');
Route::delete('/domain/{id?}', 'DomainController@delete');

