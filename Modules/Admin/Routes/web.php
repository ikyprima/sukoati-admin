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

use Modules\Admin\Entities\DataType;

Route::group(['middleware' => ['auth','verified']], function () {
    //
    Route::prefix('admin')->group(function() {
        Route::get('/', 'AdminController@index')->name('admin.index');
    
        Route::get('/user', 'UserController@index')->name('user.index');
        Route::post('/user', 'UserController@store')->name('user.store');
        Route::put('/user/{id}', 'UserController@update')->name('user.update');
        Route::delete('/user/{id}', 'UserController@destroy')->name('user.delete');

        Route::get('/role', 'RoleController@index')->name('role.index');
        Route::post('/role', 'RoleController@store')->name('role.store');
        Route::put('/role/{id}', 'RoleController@update')->name('role.update');
        Route::delete('/role/{id}', 'RoleController@destroy')->name('role.delete');

        Route::group(['middleware' => ['role_or_permission:admin']], function () {
            Route::get('/permissions', 'PermissionController@index')->name('permissions.index');
            Route::post('/permissions', 'PermissionController@store')->name('permissions.store');
            Route::put('/permissions/{id}', 'PermissionController@update')->name('permissions.update');
            Route::delete('/permissions/{id}', 'PermissionController@destroy')->name('permission.hapus');

        });
    
        //menu
        
        Route::get('/menu', 'MenuController@index')->name('menu.index');
        Route::post('/menu', 'MenuController@store')->name('menu.store');
        Route::put('/menu/{id}','MenuController@updateMenu')->name('menu.update');
    
        
        Route::put('/menu/update-child/{id}','MenuController@updateMenuChild')->name('menu.update.child');
        Route::put('/menu/update-parent/{id}','MenuController@updateMenuParent')->name('menu.update.parent');
        //database manajemen
        Route::get('/database', 'DatabaseController@index')->name('database.index');
        Route::get('/database/create', 'DatabaseController@create')->name('database.create');
        Route::post('/database', 'DatabaseController@store')->name('database.store');
        Route::get('/database/{table}/edit','DatabaseController@edit')->name('database.edit');
        Route::put('/database', 'DatabaseController@update')->name('database.update');
        Route::get('/database/{table}', 'DatabaseController@show')->name('database.show');
        Route::delete('/database/{table}', 'DatabaseController@destroy')->name('database.hapus');
        //form builder
        Route::get('/builder','BuilderController@index')->name('builder.index');
        Route::get('/builder/{table}/create','BuilderController@create')->name('builder.create');
        Route::get('/builder/{table}/edit','BuilderController@edit')->name('builder.edit');
        Route::post('/builder', 'BuilderController@store')->name('builder.store');
        Route::put('/builder', 'BuilderController@update')->name('builder.update');
        Route::delete('/builder/{table}', 'BuilderController@destroy')->name('builder.hapus');

        //sukoati controller
        try {
            foreach (DataType::all() as $dataType) {
                $controller = 'SukoatiController';
                Route::resource($dataType->slug, $controller, ['parameters' => [$dataType->slug => 'id']]); 
            }
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException("Terjadi Kesalahan: ".$e->getMessage(), 1);
        } catch (\Exception $e) {

        }

    });
});



Route::prefix('setting')->group(function() {
    Route::get('/profile', 'RoleController@index')->name('profile.index');
});
