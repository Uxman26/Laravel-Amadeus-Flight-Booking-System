<?php

use App\Http\Controllers\FooterController;
use Illuminate\Support\Facades\Route;

Route::get('footer/about-us', [FooterController::class, 'aboutus'])->name('footer.aboutus');
Route::get('footer/privacy', [FooterController::class, 'privacy'])->name('footer.privacy');

