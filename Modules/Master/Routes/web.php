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

Route::prefix('master')->group(function() {
    Route::get('/', 'MasterController@index');

    Route::get('/kategori','KategoriController@index')->name('master.kategori');
    Route::post('/kategori/simpan-data','KategoriController@store')->name('master.kategori.simpan');
    Route::put('/kategori/{id}','KategoriController@update')->name('master.kategori.update');
    Route::delete('/kategori/{id}','KategoriController@destroy')->name('master.kategori.hapus');

    Route::get('/satuan','SatuanController@index')->name('master.satuan');
    Route::post('/satuan/simpan-data','SatuanController@store')->name('master.satuan.simpan');
    Route::put('/satuan/{id}','SatuanController@update')->name('master.satuan.update');
    Route::delete('/satuan/{id}','SatuanController@destroy')->name('master.satuan.hapus');

    Route::get('/barang','BarangController@index')->name('master.barang');
    Route::post('/barang/simpan-data','BarangController@store')->name('master.barang.simpan');
    Route::put('/barang/{id}','BarangController@update')->name('master.barang.update');
    Route::delete('/barang/{id}','BarangController@destroy')->name('master.barang.hapus');

});
