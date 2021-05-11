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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test','TestController@test');
Route::get('/json','TestController@json');

Route::get('login/{provider}', 'TestController@redirect');
Route::get('login/{provider}/callback','TestController@Callback' );

Route::get('/t1', function () {
    return view('test');
});
Route::get('/t2', function () {
    dd(Session::get('provider'));

    return view('test2');
});