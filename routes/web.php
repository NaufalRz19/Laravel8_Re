<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PelangganController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', [HomeController::class, 'index']);

Route::get('/penjualan', [PenjualanController::class, 'index']);
Route::get('/penjualan/print', [PenjualanController::class, 'print']);
Route::get('/penjualan/printpdf', [PenjualanController::class, 'printpdf']);
Route::get('/user', [UserController::class, 'index'])->name('user');
Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//hak akses untuk admin
Route::group(['middleware' => 'admin'], function () {
    Route::get('/guru', [GuruController::class, 'index'])->name('guru');
    Route::get('/guru/detail/{id_guru}', [GuruController::class, 'detail']);
    Route::get('/guru/add', [GuruController::class, 'add']);
    Route::post('/guru/insert', [GuruController::class, 'insert']);
    Route::get('/guru/edit/{id_guru}', [GuruController::class, 'edit']);
    Route::post('/guru/update/{id_guru}', [GuruController::class, 'update']);
    Route::get('/guru/delete/{id_guru}', [GuruController::class, 'delete']);
    Route::get('/siswa', [SiswaController::class, 'index']);
});
//hak akses untuk user
Route::group(['middleware' => 'user'], function () {
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::get('/penjualan', [PenjualanController::class, 'index']);
    Route::get('/penjualan/print', [PenjualanController::class, 'print']);
    Route::get('/penjualan/printpdf', [PenjualanController::class, 'printpdf']);
});
//hak akses untuk pelanggan
Route::group(['middleware' => 'pelanggan'], function () {
    Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan');
});
