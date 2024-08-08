<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DaftarTransaksiController;
use App\Http\Controllers\DataBarangController;
use App\Http\Controllers\DataCustomerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/uhuy', function(){
    return view('ocim');
});
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function(){
    Route::get('/dashboard', [HomeController::class, 'dashboard']);

    Route::prefix('daftar-transaksi')->group(function(){
        Route::get('/', [DaftarTransaksiController::class, 'index']);
        Route::get('/tambah', [DaftarTransaksiController::class, 'create']);
        Route::post('/', [DaftarTransaksiController::class, 'store']);
        Route::get('/edit/{id}', [DaftarTransaksiController::class, 'edit']);
        Route::put('/{id}', [DaftarTransaksiController::class, 'update']);
        Route::delete('/{id}', [DaftarTransaksiController::class, 'destroy']);

    });

    Route::prefix('order')->group(function(){
        Route::post('/', [DaftarTransaksiController::class, 'createOrder']);
        Route::post('/createSale', [DaftarTransaksiController::class, 'storeTransaksi']);
    });

    Route::prefix('data-barang')->group(function(){
        Route::get('/', [DataBarangController::class, 'index']);
        Route::post('/', [DataBarangController::class, 'store']);
        Route::put('/{id}', [DataBarangController::class, 'update']);
        Route::delete('/{id}', [DataBarangController::class, 'destroy']);
    });

    Route::prefix('data-customer')->group(function(){
        Route::get('/', [DataCustomerController::class, 'index']);
        Route::post('/', [DataCustomerController::class, 'store']);
        Route::put('/{id}', [DataCustomerController::class, 'update']);
        Route::delete('/{id}', [DataCustomerController::class, 'destroy']);
    });
});