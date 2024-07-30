<?php

use App\Http\Controllers\admin\ApiConfigController;
use App\Http\Controllers\admin\BookingController;
use App\Http\Controllers\admin\CommissionController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\ExportDataController;
use App\Http\Controllers\admin\FinanceController;
use App\Http\Controllers\admin\ImportDataController;
use App\Http\Controllers\admin\PassengerController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\NewsController;
use App\Http\Controllers\admin\SliderController;
use App\Http\Controllers\admin\BannerController;
use App\Http\Controllers\admin\EmailController;
use App\Http\Controllers\admin\PromotionController;
use App\Http\Controllers\admin\FooterController;
use App\Http\Controllers\admin\PackageController;
use Illuminate\Support\Facades\Route;

Route::get('admin/package/invoice/{id}/{packageBooking}/{number}', [PackageController::class, 'invoice'])->name('admin.package.invoice');
Route::get('admin/package/booking', [PackageController::class, 'booking'])->name('admin.package.booking');
Route::get('admin/package/view/{id}', [PackageController::class, 'view'])->name('admin.package.view');
Route::post('admin/package/store_booking', [PackageController::class, 'store_booking'])->name('admin.package.store_booking');
Route::post('admin/package/update_package', [PackageController::class, 'update_package'])->name('admin.package.update_package');
Route::prefix('admin')->name('admin.')->middleware('auth', 'admin')->group(function () {
    Route::get('booking/daily_report', [BookingController::class, 'daily_report'])->name('booking.daily_report');
    Route::get('booking/departure', [BookingController::class, 'departure'])->name('booking.departure');
    Route::resource('dashboard', DashboardController::class);
    Route::resource('booking', BookingController::class);
    Route::resource('passenger', PassengerController::class);
    Route::resource('users', UserController::class);
    Route::resource('finance', FinanceController::class);
    Route::resource('setting', SettingController::class);
    Route::resource('api', ApiConfigController::class);
    Route::resource('commission', CommissionController::class);
    Route::get('export/booking', [ExportDataController::class, 'booking'])->name('export.booking');
    Route::get('export/passenger', [ExportDataController::class, 'passenger'])->name('export.passenger');
    Route::post('import/booking', [ImportDataController::class, 'booking'])->name('import.booking');
    Route::post('import/passenger', [ImportDataController::class, 'passenger'])->name('import.passenger');
    Route::post('import/transactions', [ImportDataController::class, 'transactions'])->name('import.transactions');
    Route::get('export/transactions', [ExportDataController::class, 'transactions'])->name('export.transactions');
    
    Route::get('package/packageBooking', [PackageController::class, 'packageBooking'])->name('package.packageBooking');
    Route::resource('package', PackageController::class);
    Route::resource('news', NewsController::class);
    Route::post('news/settings', [NewsController::class, 'settings'])->name('news.settings');
    Route::resource('slider', SliderController::class);
    Route::resource('banner', BannerController::class);
    Route::resource('promotion', PromotionController::class);

    Route::get('footer/settings', [FooterController::class, 'settings'])->name('footer.settings');
    Route::post('footer/settings/save', [FooterController::class, 'saveSettings'])->name('footer.settings.save');

    Route::get('email/index', [EmailController::class, 'index'])->name('email.index');
    Route::post('email/send', [EmailController::class, 'send'])->name('email.send');
});

Route::get('slider/promotion/{slug}', [SliderController::class, 'promotions']);
Route::post('slider/promotion/{slug}/save', [SliderController::class, 'savePromotionsInfo']);
Route::post('slider/savepopinfo', [SliderController::class, 'savePopInfo']);
