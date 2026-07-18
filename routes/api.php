<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\CheckInController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\FlashDealController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\VoucherController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class);

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/search', [ProductController::class, 'liveSearch']);
Route::get('/products/brands', [ProductController::class, 'brands']);
Route::get('/products/{slug}', [ProductController::class, 'show']);
Route::get('/products/quick-view/{product}', [ProductController::class, 'quickView']);

Route::post('/coupon/validate', [CouponController::class, 'validate']);

Route::get('/vouchers', [VoucherController::class, 'index']);

Route::get('/flash-deals', [FlashDealController::class, 'index']);

Route::get('/pages/{slug}', [PageController::class, 'show']);

Route::post('/contact', ContactController::class);

Route::post('/language/{locale}', [LanguageController::class, 'switch']);

Route::get('/order/track', [OrderController::class, 'track']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/user', [AuthController::class, 'user']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/auth/change-password', [AuthController::class, 'changePassword']);

    Route::post('/products/{slug}/review', [ProductController::class, 'storeReview']);
    Route::post('/products/{slug}/reviews/{reviewId}/reply', [ProductController::class, 'replyToReview']);

    Route::post('/checkout', [CheckoutController::class, 'store']);

    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle']);
    Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy']);

    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);

    Route::get('/account', [AccountController::class, 'show']);
    Route::put('/account', [AccountController::class, 'update']);

    Route::get('/addresses', [AddressController::class, 'index']);
    Route::post('/addresses', [AddressController::class, 'store']);
    Route::get('/addresses/{address}', [AddressController::class, 'show']);
    Route::put('/addresses/{address}', [AddressController::class, 'update']);
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy']);

    Route::post('/vouchers/collect', [VoucherController::class, 'collect']);
    Route::get('/vouchers/my', [VoucherController::class, 'myVouchers']);

    Route::post('/check-in', [CheckInController::class, 'store']);
    Route::get('/check-in/status', [CheckInController::class, 'status']);

    Route::get('/chat', [ChatController::class, 'index']);
    Route::post('/chat', [ChatController::class, 'store']);
    Route::get('/chat/{id}', [ChatController::class, 'show']);
    Route::post('/chat/{id}/reply', [ChatController::class, 'reply']);

    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead']);
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead']);
});

Route::get('/payment/{order}', [PaymentController::class, 'show']);
Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
Route::post('/payment/webhook', [PaymentController::class, 'webhook'])->name('payment.webhook');
