<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/initiate-qbo-sync', 'App\Http\Controllers\QboSyncController@initiateSync');
Route::get('/qbo-redirect', 'App\Http\Controllers\QboSyncController@qboRedirectSync');

Route::get('/send-authorization-request', 'App\Http\Controllers\QboSyncController@sendAuthorizationRequest');
