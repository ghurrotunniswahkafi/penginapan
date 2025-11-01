<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CorporateBookingController;

/* Opsional: arahkan root ke form booking */
Route::redirect('/', '/booking');

/* Booking reguler */
Route::get('/booking', [BookingController::class, 'index'])->name('booking.form');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking/review', [BookingController::class, 'review'])->name('booking.review');

/* ➜ Payment Details (BARU) */
Route::get('/payment-details', [BookingController::class, 'payment'])->name('payment.details');

/* Corporate booking */
Route::get('/corporate-booking', [CorporateBookingController::class, 'index'])->name('corporate.booking.form');
Route::post('/corporate-booking', [CorporateBookingController::class, 'store'])->name('corporate.booking.store');
Route::get('/corporate-booking/review', [CorporateBookingController::class, 'review'])->name('corporate.booking.review');
