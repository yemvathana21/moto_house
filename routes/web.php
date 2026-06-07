<?php

use App\Http\Controllers\Store\AccountController;
use App\Http\Controllers\Store\CartController;
use App\Http\Controllers\Store\CheckoutController;
use App\Http\Controllers\Store\CouponController;
use App\Http\Controllers\Store\HomeController;
use App\Http\Controllers\Store\OrderTrackingController;
use App\Http\Controllers\Store\PageController;
use App\Http\Controllers\Store\ContactController;
use App\Http\Controllers\Store\PaymentController;
use App\Http\Controllers\Store\ShopController;
use App\Http\Controllers\Store\WishlistController;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Logout;
use App\Livewire\Auth\Register;
use Illuminate\Support\Facades\Route;


Route::get('/', HomeController::class);
Route::redirect('/about-us', '/page/about-us');
Route::get('/shop', ShopController::class);
Route::get('/shop/{slug}', [ShopController::class, 'show']);
Route::post('/shop/{slug}/review', [ShopController::class, 'storeReview'])->middleware('auth');
Route::post('/shop/{slug}/review/{review}/reply', [ShopController::class, 'storeReply'])->middleware('auth');

Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

Route::get('/checkout', [CheckoutController::class, 'index']);
Route::post('/checkout', [CheckoutController::class, 'store']);

Route::post('/coupon/validate', [CouponController::class, 'validate']);

Route::get('/wishlist', [WishlistController::class, 'index']);

Route::get('/order/track', [OrderTrackingController::class, 'index'])->name('order.track');

Route::match(['get', 'post'], '/contact', ContactController::class);
Route::get('/page/{slug}', PageController::class);

Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');

Route::get('language/{locale}', [App\Http\Controllers\LanguageController::class, 'switch'])->name('language.switch');

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

Route::middleware('auth')->group(function () {
    Route::get('/my-account', [AccountController::class, 'index'])->name('account');
});

Route::post('/logout', function () {
    auth('web')->logout();
    return redirect('/');
})->name('logout');

Route::middleware(['web'])->group(function () {
    Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
    Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
    Route::post('/payment/webhook', [PaymentController::class, 'webhook'])->name('payment.webhook');
});
