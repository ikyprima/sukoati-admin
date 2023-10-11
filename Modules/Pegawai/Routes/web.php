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

Route::prefix('pegawai')->group(function() {
    Route::get('/', 'PegawaiController@index')->name('pegawai.index');
    Route::post('/simpan-data','PegawaiController@store')->name('pegawai.simpan');
    Route::put('/{id}','PegawaiController@update')->name('pegawai.update');
    Route::delete('/{id}','PegawaiController@destroy')->name('pegawai.hapus');
});

Route::prefix('pangkat')->group(function() {
    Route::get('/', 'PangkatController@index')->name('Pangkat.index');
});

Route::prefix('jabatan')->group(function() {
    Route::get('/', 'JabatanController@index')->name('Jabatan.index');
});

Route::prefix('pendidikan')->group(function() {
    Route::get('/', 'PendidikanController@index')->name('pendidikan.index');
});
