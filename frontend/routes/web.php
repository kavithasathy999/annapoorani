<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\EstimateController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\ThemeSettingController;

Route::get('/new', function () {
    $banners  = \App\Models\BannerImage::orderBy('banner_position', 'asc')->get();
    $settings = \App\Models\HomeSetting::first() ?? new \App\Models\HomeSetting();
    $brands   = \App\Models\Brand::get();
    
    $featured_ids = collect($settings->featured_product_ids ?? [])->filter()->toArray();
    if (count($featured_ids) > 0) {
        $products = \App\Models\Product::with('category')->whereIn('id', $featured_ids)->get();
    } else {
        $products = \App\Models\Product::with('category')->where('product_regular_price', '>', 0)->latest()->take(7)->get();
    }

    return view('pages.new', compact('banners', 'products', 'settings', 'brands'));
});
Route::get('/', [HomeController::class, 'index']);
Route::get('/about', [AboutController::class, 'index']);
Route::get('/safety-tips', function () {
    return view('pages.safety-tips');
})->name('safety-tips');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.submit');
Route::get('/estimate', [EstimateController::class, 'index']);
Route::get('/download-price-list', [EstimateController::class, 'downloadPDF'])->name('pricelist.download');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('/order-success', [OrderController::class, 'success'])->name('order.success');
Route::post('/send-otp', [OtpController::class, 'sendOtp'])->name('otp.send');
Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])->name('otp.verify');
Route::get('/invoice/{order_id}', [OrderController::class, 'invoicePdf'])->name('invoice.pdf');
Route::get('/terms-condition', [LegalController::class, 'terms'])->name('terms.index');

Route::get('/ajax/cities/{stateId}', [CityController::class, 'getCities']);
Route::get('/ajax/areas/{cityId}',   [CityController::class, 'getAreas']);
Route::get('/ajax/charges/{cityId}', [CityController::class, 'getCharges']);


Route::get('/{url}', [SeoController::class, 'show'])->name('seo.show');

Route::get('/customer/lookup/{phone}', [CustomerController::class, 'lookup'])->name('customer.lookup');


Route::get('/theme.css', [ThemeController::class, 'css'])->name('theme.css');

