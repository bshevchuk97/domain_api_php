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
Route::get('/domains', function (){
    return 'all domains on user';
});
Route::get('/domain/{name}', function ($name){
    return 'status on ' . $name . ' domain of user';
});
Route::post('/domain/{name}', function ($name){
    return 'created ' . $name . ' domain of user';
});
Route::put('/domain/{name}', function ($name){
    return  'activated ' . $name . ' domain of user';
});
Route::delete('/domain/{name}', function ($name){
    if($name = 'sola')
        return response()->abort(401);
    return 'deleted ' . $name . 'domain of user';
});

