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

Route::prefix('admin')->group(function() {
    Route::get('/', 'AdminController@index')->name('admin.index');
    Route::get('/role', 'RoleController@index')->name('role.index');
    Route::get('/menu', 'MenuController@index')->name('menu.index');
    Route::get('/tes', 'MenuController@tes')->name('tes');
    Route::post('/test', 'MenuController@tes')->name('test');
});
