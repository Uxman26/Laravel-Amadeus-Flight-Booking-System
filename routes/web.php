<?php

use App\Http\Controllers\agent\DashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FlightSearchController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ReIssueController;
use App\Http\Controllers\PolicyController;
use Illuminate\Support\Facades\Route;

Route::resource('/', LandingPageController::class);


Route::get('/goto_nego', [DashboardController::class, 'goto_nego'])->name('goto_nego');
Route::get('/goto_nego_fair_qr', [DashboardController::class, 'goto_nego_fair_qr'])->name('goto_nego_fair_qr');
Route::get('/flight/booking/show_off', [BookingController::class, 'show_off'])->name('flight.booking.show_off');

Route::prefix('flight')->name('flight.')->middleware('auth', 'agent')->group(function () {
    Route::resource('dashboard', DashboardController::class);
});
Route::resource('privacy_policies',PolicyController::class);
Route::prefix('flight')->name('flight.')->middleware('auth')->group(function () {
    Route::get('{origin}/{destination}/oneway/{flight_type}/{cdeparture}/{adult}/{children}/{infant}/{airline}', [FlightSearchController::class, 'oneway'])->name('search.oneway');
    Route::get('onewayFlexible/{origin}/{destination}/oneway/{flight_type}/{cdeparture}/{adult}/{children}/{infant}', [FlightSearchController::class, 'onewayFlexible'])->name('search.onewayFlexible');
    Route::get('{origin}/{destination}/return/{flight_type}/{cdeparture}/{return}/{adult}/{children}/{infant}/{airline}', [FlightSearchController::class, 'return'])->name('search.return');
    Route::get('{origin1}/{destination1}/{departureDate1}/{origin2}/{destination2}/{departureDate2}/{origin3}/{destination3}/{departureDate3}/{origin4}/{destination4}/{departureDate4}/{adult}/{children}/{infant}/{airline}', [FlightSearchController::class, 'multiCity'])->name('search.multiCity');
    Route::get('{origin}/{destination}/oneway/{flight_type}/{cdeparture}/{adult}/{children}/{infant}', [FlightSearchController::class, 'oneway']);
    Route::get('onewayFlexible/{origin}/{destination}/oneway/{flight_type}/{cdeparture}/{adult}/{children}/{infant}', [FlightSearchController::class, 'onewayFlexible']);
    Route::get('{origin}/{destination}/return/{flight_type}/{cdeparture}/{return}/{adult}/{children}/{infant}', [FlightSearchController::class, 'return']);
    Route::get('{origin1}/{destination1}/{departureDate1}/{origin2}/{destination2}/{departureDate2}/{origin3}/{destination3}/{departureDate3}/{origin4}/{destination4}/{departureDate4}/{adult}/{children}/{infant}', [FlightSearchController::class, 'multiCity']);

    Route::post('search/verify_price', [FlightSearchController::class, 'verify_price'])->name('search.verify_price');
    Route::post('search/verify_date', [BookingController::class, 'verify_date'])->name('search.verify_date');
    Route::resource('search', FlightSearchController::class);
    Route::resource('booking', BookingController::class);
    Route::resource('invoice', InvoiceController::class);
    Route::resource('reissue', ReIssueController::class);
});

Route::get('flight/airlines', [FlightSearchController::class, 'airlines'])->name('flight.airlines');
Route::get('booking/new_order', [BookingController::class, 'new_order'])->name('booking.new_order');
Route::post('booking/store_daily_report', [BookingController::class, 'store_daily_report'])->name('booking.store_daily_report');
Route::get('booking/reopen_request', [BookingController::class, 'reopen_request'])->name('booking.reopen_request');
Route::get('booking/create_daily_report', [BookingController::class, 'create_daily_report'])->name('booking.create_daily_report');
Route::post('/flight/booking/get_passenger', [BookingController::class, 'get_passenger'])->name('flight.booking.get_passenger');
Route::get('/flight/booking/{id}/{hash}/{pnr}', [BookingController::class, 'ticket'])->name('flight.ticket.show.passenger');
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    ECHO 'dONE';
});


require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/agent.php';
require __DIR__ . '/footer.php';
