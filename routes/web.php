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
                
                // Route::group(
                //     ['prefix' => 'produk'],
                //     function () {
                        Route::resource('produk', 'ProductController');
                        // Route::get('/', 'ProductController@index')->name('produk.index');
                        // Route::get('/data', 'ProductController@paginated')->name('product.data');
                        // Route::post('/', 'ProductController@store')->name('produk.store');
                        // Route::get('/{id}', 'ProductController@show')->name('product.show');
                        // Route::put('/{id}', 'ProductController@update')->name('product.update');
                        // Route::delete('/{id}', 'ProductController@destroy')->name('product.destroy');
                  
                    // }
                // );
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
