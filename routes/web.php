<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\PengunjungController;
use App\Http\Controllers\BookingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

// AUTH
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');

// ADMIN routes — gunakan FQCN middleware untuk menghindari alias yang belum terdaftar
Route::middleware([\App\Http\Middleware\AdminAuth::class])->group(function () {

    // Dashboard Admin -> point to controller's dashboard() method
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Kamar
    Route::get('/admin/kamar', [KamarController::class, 'index'])->name('kamar.index');
    Route::get('/admin/kamar/tambah', [KamarController::class, 'create'])->name('kamar.create');
    Route::post('/admin/kamar/simpan', [KamarController::class, 'store'])->name('kamar.store');
    Route::get('/admin/kamar/edit/{id}', [KamarController::class, 'edit'])->name('kamar.edit');
    Route::post('/admin/kamar/update/{id}', [KamarController::class, 'update'])->name('kamar.update');
    Route::get('/admin/kamar/hapus/{id}', [KamarController::class, 'destroy'])->name('kamar.destroy');

    // Pengunjung
    Route::get('/admin/pengunjung', [PengunjungController::class, 'index'])->name('pengunjung.index');
    Route::get('/admin/pengunjung/tambah', [PengunjungController::class, 'create'])->name('pengunjung.create');
    Route::post('/admin/pengunjung/simpan', [PengunjungController::class, 'store'])->name('pengunjung.store');
    Route::get('/admin/pengunjung/edit/{id}', [PengunjungController::class, 'edit'])->name('pengunjung.edit');
    Route::post('/admin/pengunjung/update/{id}', [PengunjungController::class, 'update'])->name('pengunjung.update');
    Route::get('/admin/pengunjung/hapus/{id}', [PengunjungController::class, 'destroy'])->name('pengunjung.destroy');

    // Booking
    Route::get('/admin/booking/corporate', [BookingController::class, 'corporate'])->name('booking.corporate');
    Route::post('/admin/booking/corporate/simpan', [BookingController::class, 'storeCorporate'])->name('booking.corporate.store');

    Route::get('/admin/booking/individu', [BookingController::class, 'individu'])->name('booking.individu');
    Route::post('/admin/booking/individu/simpan', [BookingController::class, 'storeIndividu'])->name('booking.individu.store');
});