<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/barang', function (Request $request) {
    return $request->user();
});

Route::get('list-barang', 'BarangController@listBarang')->name('api.listBarang');

Route::get('list-barang-tes', 'BarangController@listBarangTes')->name('api.listBarang.tes');

Route::get('init-lokasi', 'BarangController@initLokasi')->name('init.lokasi');

Route::post('post-lokasi', 'BarangController@postAbsen')->name('post.absen');
