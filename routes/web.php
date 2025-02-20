<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\barangKeluarController;
use App\Http\Controllers\barangMasukController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\pegawaiController;
use App\Http\Controllers\pelangganController;
use App\Http\Controllers\stokController;
use App\Http\Controllers\suplierController;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;



Route::get('/', [AuthController::class, 'index']);
Route::post('/', [AuthController::class, 'login'])->name('login');


Route::middleware(['auth', 'cekLevel:superadmin,admin'])->group(function(){


    Route::get('/dashboard', [dashboardController::class, 'index']);

    Route::get('/logout', [AuthController::class, 'logout']);


    /**
     * Ini routing pegawai
     */

    Route::controller(pegawaiController::class)->group(function(){

        Route::get('/pegawai', 'index');

        Route::post('/pegawai/add', 'store')->name('addPegawai');

        Route::get('pegawai/edit/{id}', 'edit');
        Route::post('pegawai/edit/{id}', 'update');

        Route::get('/pegawai/delete/{id}', 'destroy'); //ketik baris ini

    });

    Route::controller(suplierController::class)->group(function(){
        Route::get('/suplier', 'index');
        Route::get('/suplier/add', 'create');
        Route::post('/suplier/add', 'store');
        Route::get('/suplier/edit/{id}', 'edit');
        Route::post('/suplier/edit/{id}', 'update');


    });
    /**
     * Ini routing Stok
     */
    Route::controller(stokController::class)->group(function(){
        Route::get('/stok', 'index');
        Route::get('/stok/add', 'create');
        Route::post('/stok/add', 'store');
        Route::get('/stok/edit/{id}', 'edit');
        Route::post('/stok/edit/{id}', 'update');

    });






    /**
     * Ini routing Barang Masuk
     */





    /**
     * Ini routing Barang Keluar
     */
    Route::controller(barangKeluarController::class)->group(function(){
        Route::get('/barang-keluar', 'index');

        Route::get('/barang-keluar/add', 'create');
        Route::post('/barang-keluar/add', 'store');

        Route::post('/barang-keluar/save', 'savebarangKeluar')->name('addBarangKeluar');

     





    });





    /**
     * Ini routing Pelanggan
     */
    Route::controller(pelangganController::class)->group(function(){
        Route::get('/pelanggan', 'index');

        Route::get('/pelanggan/add', 'create');
        Route::post('/pelanggan/add', 'store');

        Route::get('/pelanggan/edit/{id}', 'edit');
        Route::post('/pelanggan/edit/{id}', 'update');

        Route::get('/pelanggan/{id}', 'destroy');
     });



    /**
     * Ini routing Suplier
     */
    Route::controller(barangMasukController::class)->group(function(){
        Route::get('/barang-masuk', 'index');

        Route::get('/barang-masuk/add', 'create');
        Route::post('/barang-masuk/add', 'store');

        Route::get('/barang-masuk/{id}', 'destroy');
     });

});
