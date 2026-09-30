<?php

use App\Http\Controllers\API\Banner\BannerController;
use App\Http\Controllers\API\Category\CategoryController;
use App\Http\Controllers\API\Home\HomeController;
use App\Http\Controllers\API\Master\MasterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Authenticate\AuthController;
use App\Http\Controllers\API\Brand\BrandController;
use App\Http\Controllers\API\Color\ColorController;
use App\Http\Controllers\API\ConversationController;
use App\Http\Controllers\API\FilterController;
use App\Http\Controllers\API\LegalPage\LegalPageController;
use App\Http\Controllers\API\Notification\NotificationController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\Profile\ProfileController;
use App\Http\Controllers\API\SellerInfo\SellerInfoController;
use App\Http\Controllers\API\PromotController;
use App\Http\Controllers\API\PaymentGatewayController;
use App\Http\Controllers\API\Transaction\TransactionController;
use App\Http\Controllers\API\WishlistControoler;
use App\Http\Controllers\Api\ExportController;
use App\Http\Controllers\BroadcastController;
use App\Http\Controllers\Api\OfferController;
use Illuminate\Http\Request;




// Master Controller
Route::controller(MasterController::class)->group(function () {
    Route::get('/master', 'index');
});

// Home Controller
Route::controller(HomeController::class)->group(function () {
    Route::get('/home', 'index');
    Route::get('/home/near-products', 'nearProducts');
});

// Category Controller
Route::middleware('throttle:100,1')->controller(CategoryController::class)->group(function () {
    Route::get('/categories', 'index');
    Route::get('/sub-categories/{id}', 'subCategories');
});

// banner Controller
Route::controller(BannerController::class)->group(function () {
    Route::get('/banner', 'index');
});

// SellerInfoController Controller
Route::prefix('seller')->controller(SellerInfoController::class)->group(function () {
    Route::get('/info', 'index');
    Route::get('/review/show/{id}', 'showReview');
    Route::post('/review/store/{id}', 'storeReview')->middleware('auth:sanctum');
    Route::post('/report/{id}', 'storeReport')->middleware('auth:sanctum');
});

// ProfileController Controller
Route::controller(ProfileController::class)->group(function () {
    Route::get('/profile', 'index')->middleware('auth:sanctum');
    Route::post('/profile/update', 'update')->middleware('auth:sanctum');
});

// LegalPageController Controller
Route::controller(LegalPageController::class)->group(function () {
    Route::get('pages/{type}', 'index');
});

// Transaction History
Route::middleware('auth:sanctum')->controller(TransactionController::class)->group(function () {

    Route::get('/payment-histories', 'paymentHistory');
    Route::get('/wallet-payment-histories', 'walletPaymentHistory');
    Route::get('/payment-summary/{id}', 'paymentSummary');

    // Wallet balance route
    Route::get('/wallet/balance', function () {
        return response()->json([
            'message' => 'Balance retrieved successfully',
            'data' => [
                'balance' => auth()->user()->wallet->balance ?? 0
            ]
        ], 200);
    });
});



// Notification
Route::middleware('auth:sanctum')->prefix('notifications')->controller(NotificationController::class)->group(function () {
    Route::get('/', 'getAllNotifications');
    Route::get('/count', 'notificationsCount');
    Route::post('/read/{id}', 'notificationRead');
    Route::post('/read-all', 'notificationReadAll');
});


// Authenticate
Route::controller(AuthController::class)->group(function () {

    // Public routes
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/send-otp', 'submitEmail');
    Route::post('/user/verify-otp', 'verifyOtp');
    Route::post('/user/resend-otp', 'resendOtp');
    Route::post('/forget-password', 'forgetPassword');
    Route::post('/verify-reset-otp', 'verifyResetOtp');
    Route::post('/reset-password', 'resetPassword');

    // Protected routes (require auth:sanctum)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/user/change-password', 'changePassword');
        Route::post('/user/delete-account', 'deleteAccount');
        Route::post('/user/logout', 'logout');
    });
});


Route::prefix('products')->controller(ProductController::class)->group(function () {

    // Public routes (no auth required)
    Route::get('/', 'index');
    Route::get('/show/{id}', 'show');
    Route::get('/search', 'searchManage');
    Route::get('/boosted', 'boostedProducts');
    Route::get('/new-products', 'newProducts');

    // Protected routes (auth:sanctum)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/store', 'store');
        Route::post('/update/{id}', 'update');
        Route::post('/copy/{id}', 'makeCopy');
        Route::get('/my-ads', 'myAds');
        Route::delete('/trash/{id}', 'moveToTrash');
        Route::get('/get-trashed', 'trashed');
        Route::post('/restore/{id}', 'restore');
        Route::post('/sold-out', 'soldout');
        Route::get('/soldout', 'soldOutAds');
    });
});


Route::prefix('boostplan')->controller(PromotController::class)->group(function () {
    Route::get('/', 'boostplan');
    Route::post('/checkout', 'checkoutApi');
});

Route::prefix('payment-gateways')->controller(PaymentGatewayController::class)->group(function () {
    Route::get('/',  'index');
});

Route::prefix('filters')->controller(FilterController::class)->group(function () {
    Route::get('/',  'filter');
});

Route::middleware('auth:sanctum')->prefix('wishlist')->controller(WishlistControoler::class)->group(function () {
    Route::get('/',  'index');
    Route::post('/toggle', 'toggle');
});

Route::prefix('brands')->controller(BrandController::class)->group(function () {
    Route::get('/',  'index');
});

Route::prefix('colors')->controller(ColorController::class)->group(function () {
    Route::get('/',  'index');
});



Route::middleware(['auth:sanctum', 'throttle:60,1'])->prefix('conversation')->controller(ConversationController::class)->group(function () {
    Route::post('/makeOffer',  'store');
    Route::post('/send-message',  'sendMessage');
    Route::post('/mark-as-read/{user}',  'markAsRead');
    Route::get('/fetchMessages/{user}', 'fetchMessages');
    Route::get('/get-user-details', 'getUserDetails');
    Route::get('/chat-heads', 'chatHead');
});


Route::middleware('auth:sanctum')->prefix('broadcast/auth')->controller(BroadcastController::class)->group(function () {
    Route::get('/', 'index');
});

// Export Receipts
Route::middleware('auth:sanctum')->get('/export/receipt/{offer}', [ExportController::class, 'exportReceipt']);
