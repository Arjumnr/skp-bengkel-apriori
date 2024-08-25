<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Route::get('/', [AntrianController::class, 'antrian'])->name('antrian');
// Route::post('/', [AntrianController::class, 'post'])->name('postAntrian');
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login-post', [AuthController::class, 'postLogin'])->name('loginPost');
// Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

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
