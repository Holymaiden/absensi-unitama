<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController as Auths;


Route::get('/', function () {
    return view('welcome');
});

// Route Auth
Route::get('/auth/login', [Auths::class, 'index']);
Route::post('/auth/login', [Auths::class, 'login'])->name('login');
Route::get('/auth/logout', [Auths::class, 'logout'])->name('logout');

// Route User
Route::group(['prefix' => '',  'namespace' => 'App\Http\Controllers\Apps',  'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/data', 'HomeController@data')->name('home.data');
    Route::get('/dataCuti', 'HomeController@dataCuti')->name('home.dataCuti');
    Route::post('/pengajuanCuti', 'HomeController@pengajuanCuti')->name('home.pengajuanCuti');
    Route::post('/abseni', 'HomeController@absensi')->name('home.absensi');
    Route::post('/izinSakit', 'HomeController@izinSakit')->name('home.izinSakit');
    Route::post('/izin', 'HomeController@izin')->name('home.izin');
    Route::get('/validateSunday', 'HomeController@validateSunday')->name('home.validateSunday');
});

// Route Admin
Route::group(['prefix' => '',  'namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['auth', 'admin']], function () {
    Route::group(['prefix' => 'admin'], function () {

        Route::get('/', 'DashboardController@index')->name('dashboard');

        Route::group(['prefix' => '/roles'], function () {
            Route::get('/', 'RoleController@index')->name('roles');
            Route::get('/data', 'RoleController@data')->name('roles.data');
            Route::post('/store', 'RoleController@store')->name('roles.store');
            Route::get('/{id}/edit', 'RoleController@edit')->name('roles.edit');
            Route::put('/{id}', 'RoleController@update')->name('roles.update');
            Route::delete('/{id}', 'RoleController@destroy')->name('roles.delete');
        });

        Route::group(['prefix' => '/karyawan'], function () {
            Route::get('/', 'KaryawanController@index')->name('karyawan');
            Route::get('/data', 'KaryawanController@data')->name('karyawan.data');
            Route::post('/store', 'KaryawanController@store')->name('karyawan.store');
            Route::get('/{id}/edit', 'KaryawanController@edit')->name('karyawan.edit');
            Route::put('/{id}', 'KaryawanController@update')->name('karyawan.update');
            Route::delete('/{id}', 'KaryawanController@destroy')->name('karyawan.delete');
        });

        Route::group(['prefix' => '/kehadiran'], function () {
            Route::get('/', 'KehadiranController@index')->name('kehadiran');
            Route::get('/data', 'KehadiranController@data')->name('kehadiran.data');
            Route::post('/store', 'KehadiranController@store')->name('kehadiran.store');
            Route::get('/{id}/edit', 'KehadiranController@edit')->name('kehadiran.edit');
            Route::put('/{id}', 'KehadiranController@update')->name('kehadiran.update');
            Route::delete('/{id}', 'KehadiranController@destroy')->name('kehadiran.delete');
            Route::get('/export/excel', 'KehadiranController@exportExcel')->name('kehadiran.exportExcel');
        });

        Route::group(['prefix' => '/cuti'], function () {
            Route::get('/', 'CutiController@index')->name('cuti');
            Route::get('/data', 'CutiController@data')->name('cuti.data');
            Route::post('/store', 'CutiController@store')->name('cuti.store');
            Route::get('/{id}/edit', 'CutiController@edit')->name('cuti.edit');
            Route::put('/{id}', 'CutiController@update')->name('cuti.update');
            Route::delete('/{id}', 'CutiController@destroy')->name('cuti.delete');
            Route::get('/{id}/cuti', 'CutiController@printCuti')->name('cuti.printCuti');
        });
    });
});

// Route Error Handling
Route::get('unauthorized', function ($title = null) {
    $this->response['code'] = "401";
    $this->response['message'] = "unauthorized access permission";
    return view('errors.message', ['message' => $this->response]);
})->name('unauthorized');

// Route Artisan
Route::get('/cc', function () {
    Artisan::call('optimize:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
});
