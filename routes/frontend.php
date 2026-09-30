<?php

use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\Auth\UserAuthController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\Chat\ChatController;
use App\Http\Controllers\Frontend\ContactUsController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\Profile\ProfileController;
use App\Http\Controllers\Frontend\SearchKeyController;
use App\Http\Controllers\Frontend\SellerinfoController;
use App\Http\Controllers\Frontend\Transaction\PaymentCompleteController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\ReportSellerController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;
use App\Events\UserStatusChanged;
use App\Http\Controllers\Frontend\PageController;
use Illuminate\Support\Facades\Auth;

// Redirect /admin based on auth status
Route::get('/admin', function () {
    if (auth()->check() && auth()->user()->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('admin.login.view');
});

// Login and Registation
Route::get('/user/login', [UserAuthController::class, 'showLogin'])->name('login');
Route::get('/user/register', [UserAuthController::class, 'showRegistration'])->name('register');
Route::post('/user/login', [UserAuthController::class, 'login'])->name('user.login.submit')->middleware('throttle:5,1');
Route::post('/user/register', [UserAuthController::class, 'registration'])->name('user.register.submit')->middleware('throttle:3,1');
Route::get('/user/forgot/password', [UserAuthController::class, 'forgotIndex'])->name('user.forgot.password');
Route::post('/user/forgot/password/', [UserAuthController::class, 'forgotUpdate'])->name('user.forgot.password.update');
Route::post('/user/forgot/password/verify-otp', [UserAuthController::class, 'verifyForgotOtp'])->name('user.forgot.password.verify.otp');
Route::get('/user/forgot/password/reset', [UserAuthController::class, 'setResetPassword'])->name('user.forgot.password.reset');
Route::post('/user/forgot/password/store', [UserAuthController::class, 'storeResetPassword'])->name('user.forgot.password.store');


// Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/', [\App\Http\Controllers\Frontend\SpaController::class, 'index'])->name('home');
// Productsub
Route::get('/products/{category?}', [ProductController::class, 'index'])->name('products');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product-details');
// for seller
Route::get('/post-details/{id}', [ProductController::class, 'show'])->name('post-details');
Route::get('/product-ad', [ProductController::class, 'productAd'])->name('product-ad');
Route::get('/get-subcategories/{id}', [CategoryController::class, 'getSubcategories'])->name('get-subcategories');
Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');
Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
Route::get('/search', [ProductController::class, 'search'])->name('products.search');
Route::post('/product/make-copy/{id}', [ProductController::class, 'makeCopy'])->name('product.makeCopy');

// Wishlist Routes
Route::middleware('auth')->group(function () {
    Route::get('/wishlist/add/{id}', [WishlistController::class, 'addWishlist'])->name('wishlist.add');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
});


Route::middleware('auth')->group(function () {
    //verify
    Route::get('/user/verify-email', [UserAuthController::class, 'showVerify'])->name('user.verify');
    Route::post('/user/verify-email', [UserAuthController::class, 'submitEmail'])->name('user.verify.submit');
    Route::get('/user/verify-otp', [UserAuthController::class, 'showVerifyOtp'])->name('user.verify.otp');
    Route::post('/user/verify-otp', [UserAuthController::class, 'verify'])->name('user.verify.otp.submit');
    // OTP resend
    Route::post('/user/resend-otp', [UserAuthController::class, 'resendOtp'])->name('user.resend.otp');
    // password change
    Route::get('/user/change-password', [UserAuthController::class, 'changePasswordindex'])->name('user.change-password-index');
    Route::post('/user/change-password', [UserAuthController::class, 'changePassword'])->name('user.change-password');
    //user - soft - delete
    Route::get('/user/delete-account', [UserAuthController::class, 'showDeleteAccount'])->name('user.show-delete-account');
    Route::post('/user/delete-account', [UserAuthController::class, 'deleteAccount'])->name('user.delete-account');
    //logout
    Route::post('logout', [UserAuthController::class, 'logout'])->name('logout');
    Route::post('user/logout', [UserAuthController::class, 'logout'])->name('user.logout');

    // Barter Offers (SPA)
    Route::get('user/my-offers', function () {
        return \Inertia\Inertia::render('MyOffers');
    })->name('user.offers');
    Route::get('user/offers/{offer}/receipt', [\App\Http\Controllers\Api\ExportController::class, 'exportReceipt'])
        ->name('user.offers.receipt');

    // Barter Offers API (using Web Session instead of Sanctum for SPA)
    Route::prefix('api/offers')->middleware('idempotency')->controller(\App\Http\Controllers\Api\OfferController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::get('/show/{offer}', 'show');
        Route::post('/update-status/{offer}', 'updateStatus');
        Route::post('/confirm/{offer}', 'confirm');
    });

    //Now From  >> -------- >> ProfileController <<----------------->>
    Route::get('user/profile', [ProfileController::class, 'showProfile'])->name('user.profile');
    Route::post('user/profile/update/{id}', [ProfileController::class, 'update'])->name('user.profile-update');
    Route::get('user/my-ads', [ProfileController::class, 'showMyAds'])->name('user.my-ads');
    Route::get('user/my-wishlist', [ProfileController::class, 'showWishlist'])->name('user.show-wishlist');

    //Start Notifications
    Route::get('user/my-notifications', [ProfileController::class, 'showUserNotifications'])->name('user.show-notifications');
    Route::get('user/my-all/notifications', [ProfileController::class, 'readAllNotifications'])->name('user.read-all-notifications');

    Route::post('/user/notification/read', [ProfileController::class, 'readSingleNotification'])->name('user.notification.read');

    //End Notifications

    Route::get('user/my-review', [ProfileController::class, 'reviewIndex'])->name('user.review-index');
    Route::get('user/my-trash', [ProfileController::class, 'trashIndex'])->name('user.trash-index');
    Route::post('/user/selling-post/{id}/trash', [ProfileController::class, 'moveToTrash'])->name('selling-post.trash');
    Route::post('/user/selling-post/{id}/restore', [ProfileController::class, 'restore'])->name('selling-post.restore');
    Route::get('/product/promote/{id}', [ProfileController::class, 'showPromoteAds'])->name('product.promote');
    Route::post('/product/soldout/{id}', [ProfileController::class, 'SoldOut'])->name('product.soldout');
    Route::get('/user/sold-out', [ProfileController::class, 'soldOutAds'])->name('user.soldout');
    Route::post('/user/soldout', [ProfileController::class, 'markAsSold'])->name('user.soldout-mark');
});

Route::get('/seller-info/{id}', [SellerinfoController::class, 'index'])->name('seller-info');

Route::post('/seller-info/review', [SellerinfoController::class, 'storeReview'])->name('seller-info.review');
Route::get('/selling-post/promote/checkout', [TransactionController::class, 'checkout'])->name('selling-post.promot');
Route::post('/auto-pay', [TransactionController::class, 'autoPay'])->name('product.auto-pay');



/*
Route::post('/transactions/store', [TransactionController::class, 'store'])->name('transactions.store');
Route::get('user/my-payment', [TransactionController::class, 'paymenthistory'])->name('user.payment-history');

Route::get('/payment/{identifier}', [TransactionController::class, 'paymentView'])->name('payment.view');


Route::withoutMiddleware(['web', 'auth', 'auth:web', 'verified'])->controller(PaymentCompleteController::class)->group(function () {
    //paypal
    Route::get('paypal/payment/success/{identifier}', 'paypalPaymentSuccess')->name('paypal.payment.success');
    Route::get('paypal/payment/cancel', 'paypalPaymentCancel')->name('paypal.payment.cancel');
    //stripe
    Route::get('stripe/payment/success/{identifier}', 'stripePaymentSuccess')->name('stripe.payment.success');
    Route::get('stripe/payment/cancel', 'stripePaymentCancel')->name('stripe.payment.cancel');
    //amrpay
    Route::post('aamarpay/payment/success', 'aamarpayPaymentSuccess')->name('aamrpay.payment.success');
    Route::post('aamarpay/payment/fail', 'aamarpayPaymentFail')->name('aamrpay.payment.fail');
    Route::get('aamarpay/payment/cancel', 'aamarpayPaymentCancel')->name('aamrpay.payment.cancel');
});

Route::controller(WalletController::class)->group(function () {
    Route::get('user/my-wallet', 'showWallet')->name('user.my-wallet');
    Route::get('user/my-wallet/create', 'create')->name('user.my-wallet.create');
    Route::post('user/my-wallet/store', 'store')->name('user.my-wallet.store');
    Route::get('wallet/payment/{identifier}', 'paymentViews')->name('wallet.payment.views');
});
*/


// About
Route::get('/about-us', [AboutController::class, 'index'])->name('about.us');
// Contact
Route::redirect('/conact-us', '/contact-us', 301);
Route::redirect('/conact-us/store', '/contact-us', 301);
Route::get('/contact-us', [ContactUsController::class, 'index'])->name('contact.us');
Route::post('/contact-us/store', [ContactUsController::class, 'store'])->name('guest.contact.store');
//Legal page
Route::get('/page/{page}', [PageController::class, 'index'])->name('guest.pages');


// searchKey
Route::get('/search-suggestions', [SearchKeyController::class, 'suggest'])->name('search.suggestions');
Route::post('/save-search', [SearchKeyController::class, 'store'])->name('search.store');


Route::middleware('auth')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/make-offer', [ChatController::class, 'store'])->name('make.offer');
    Route::get('/fetch-messages/{user}', [ChatController::class, 'fetchMessages'])->name('fetch.messages');
    Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('send.message');
    Route::get('/chat/user/details', [ChatController::class, 'getUserDetails'])->name('chat.user.details');
    Route::post('/mark-read/{user}', [ChatController::class, 'markAsRead'])->name('mark.read');
    Route::get('/chat/users-paginated', [ChatController::class, 'usersPaginated'])->name('chat.users.paginated');
    Route::get('/chat/messages-paginated/{user}', [ChatController::class, 'messagesPaginated'])->name('chat.messages.paginated');
});


Route::prefix('report-seller')->name('report.seller.')->controller(ReportSellerController::class)->group(function () {
    Route::post('/store', 'store')->name('store');
});


Route::post('/keep-alive', function () {
    $user = Auth::user();

    $user->update([
        'last_active' => now()
    ]);

    event(new UserStatusChanged($user->id, true));

    return response()->json(['status' => 'ok']);
})->middleware('auth')->name('keep.alive');

// this is proxy url
// Route removed because it blocks other routes and causes 404 errors
