<?php

use Illuminate\Support\Facades\Route;
//return to view dashboard
// Route::get('/',  [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
Route::get('/logout' , [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::get('/login', [App\Http\Controllers\AuthController::class, 'index'])->name('login');
Route::post('/login-post', [App\Http\Controllers\AuthController::class, 'postLogin'])->name('loginPost');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');


Route::group(
    ['prefix' => '',  'namespace' => 'App\Http\Controllers',  'middleware' => ['auth']],
    function () {
        Route::get('/', 'DashboardController@index')->name('dashboard');
        Route::group(
            ['prefix' => 'admin'],
            function () {
                
                Route::group(
                    ['prefix' => 'barang'],
                    function () {
                        Route::get('/', 'BarangController@index')->name('barang');
                        // Route::get('/data', 'BarangController@paginated')->name('barang.data');
                        // Route::post('/', 'BarangController@store')->name('barang.store');
                        // Route::get('/{id}', 'BarangController@show')->name('barang.show');
                        // Route::put('/{id}', 'BarangController@update')->name('barang.update');
                        // Route::delete('/{id}', 'BarangController@destroy')->name('barang.destroy');
                  
                    }
                );
            }
        );
    }
);
// Route::group(['middleware' => ['auth']], function () {

//     Route::group(['middleware' => ['admin:1']], function () {
//         Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
//         Route::resource('users', UsersController::class);
//         Route::resource('jenis', JenisController::class);
//         Route::resource('antrian', AntrianAdminController::class);
//         Route::resource('barang', BarangController::class);
//         Route::resource('servis', ServisController::class);
//         Route::resource('penjualan', PenjualanController::class);
//         Route::resource('honor', HonorController::class);


            
//     });
// });
