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
})->name('home');

Route::get('/domains', 'DomainController@index')->name('domains.index');
Route::post('/domains', 'DomainController@store')->name('domains.store');
Route::get('/domains/{id}', 'DomainController@show')->name('domains.show');
Route::post('/domains/{id}/domain-checks', 'DomainCheckController@store')->name('domain-checks.store');
