<?php

use App\Http\Controllers\agent\BookingController;
use App\Http\Controllers\agent\DashboardController;
use App\Http\Controllers\agent\PassengerController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::prefix('agent')->name('agent.')->middleware('auth', 'agent')->group(function () {
    Route::get('booking/daily_report', [BookingController::class, 'daily_report'])->name('booking.daily_report');
    Route::get('booking/departure', [BookingController::class, 'departure'])->name('booking.departure');
    Route::resource('dashboard', DashboardController::class);
    Route::resource('transaction', TransactionController::class);
    Route::resource('booking', BookingController::class);
    Route::resource('passenger', PassengerController::class);
});
