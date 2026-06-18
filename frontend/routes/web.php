<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\EstimateController;

use App\Http\Controllers\BankController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\ThemeSettingController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/about', [AboutController::class, 'index']);
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.submit');
Route::get('/bank', [BankController::class, 'index']);
Route::get('/estimate', [EstimateController::class, 'index']);
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('/order-success', [OrderController::class, 'success'])->name('order.success');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{url}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/terms-condition', [LegalController::class, 'terms'])->name('terms.index');

Route::get('/ajax/cities/{stateId}', [CityController::class, 'getCities']);
Route::get('/ajax/areas/{cityId}',   [CityController::class, 'getAreas']);


Route::get('/{url}', [SeoController::class, 'show'])->name('seo.show');

Route::get('/customer/lookup/{phone}', [CustomerController::class, 'lookup'])->name('customer.lookup');


Route::get('/theme.css', [ThemeController::class, 'css'])->name('theme.css');


