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

Route::middleware('auth:api')->get('/pegawai', function (Request $request) {
    return $request->user();
});

Route::prefix('pendidikan')->group(function() {
    Route::get('/', 'PendidikanController@apiPendidikan')->name('pendidikan');
});
Route::prefix('pangkat')->group(function() {
    Route::get('/', 'PangkatController@apiPangkat')->name('pangkat');
});
Route::prefix('jabatan')->group(function() {
    Route::get('/', 'JabatanController@apiJabatan')->name('jabatan');
});
Route::prefix('profile')->group(function() {
    Route::get('/{id}', 'PegawaiController@apiProfilePegawai')->name('profile.pegawai');
});