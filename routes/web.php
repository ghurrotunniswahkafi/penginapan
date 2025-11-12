<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;


Route::get('/', [BerandaController::class, 'show'])->name('home');

Route::get('/beranda', [BerandaController::class, 'edit'])->name('beranda.edit');
Route::put('/beranda/{id}', [BerandaController::class, 'update'])->name('beranda.update');

Route::get('/', [BerandaController::class, 'show'])->name('beranda.show');
Route::get('/cek-kamar', [BerandaController::class, 'cekKamar'])->name('cek.kamar');


