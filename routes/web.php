<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BoostPlanController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\LegalPageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\SellingPostController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CMS\CMSController;
use App\Http\Controllers\CMS\NavigationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CreateSuperAdmin;
use App\Http\Controllers\Settings\BusinessSettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FastSellingController;
use App\Http\Controllers\Frontend\SocialAuthController;
use App\Http\Controllers\PaymentGatewayController;
use App\Http\Controllers\ReportSellerController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Settings\GeneralSettingController;
use App\Http\Controllers\Settings\PolicyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::controller(CreateSuperAdmin::class)->middleware('guest')->group(function () {
    Route::get('/create-root', 'index')->name('create.root');
    Route::any('/create-superadmin', 'store')->name('create.superadmin');
});

// change language
Route::get('/change-language', function (Request $request) {
    if ($request->language) {
        session()->put('locale', $request->language);
    }
    return back();
})->name('change.language');

Route::controller(SocialAuthController::class)->group(function () {
    // Redirect Route
    Route::get('/auth/redirect/{provider}', 'redirect')->name('social.auth.redirect');

    // Callback Route
    Route::get('auth/{provider}/callback', 'callback')->name('social.auth.callback');

    // API Login Route
    // Route::post('/api/auth/login/{provider}', 'apiLogin')->name('api.social.auth.login');
});


// Forgot Password Routes
Route::get('/password/reset', [PasswordResetController::class, 'emailForm'])->name('password.request');
Route::post('/password/email', [PasswordResetController::class, 'resetLink'])->name('password.email');

// Reset Password Routes
Route::get('/password/reset/{token}', [PasswordResetController::class, 'resetForm'])->name('password.reset');
Route::post('/password/reset', [PasswordResetController::class, 'resetPassword'])->name('password.update');





// User Routes
Route::controller(UserController::class)->group(function () {
    Route::get('/users/export', 'usersReport')->name('users.export');

    Route::get('/users/{status?}', 'index')->name('users.index')->middleware('permission:users.index');
    Route::get('/users/trash', 'trash')->name('users.trash')->middleware('permission:users.trash');

    Route::get('/users/{id}/edit', 'edit')->name('users.edit');
    Route::post('/users/{id}/update', 'update')->name('users.update');
    Route::patch('/users/{id}/status', 'updateStatus')->name('users.updateStatus')->middleware('permission:users.updateStatus');
    Route::get('/users/show/report/{id}', 'showReports')->name('users.show.reports');

    Route::get('/users/delete/{id}', 'delete')->name('users.delete');
    Route::get('/users/restore/{id}', 'restore')->name('users.restore');
});

// Selling Post Routes
Route::prefix('/posts')->controller(SellingPostController::class)->group(function () {
    Route::get('/products/export', 'productReport')->name('products.export');
    Route::get('/{status?}', 'index')->name('posts.index')->middleware('permission:posts.index');
    Route::get('/trash', 'trash')->name('posts.trash')->middleware('permission:posts.trash');
    Route::get('/{id}/edit', 'edit')->name('posts.edit')->middleware('permission:posts.edit');
    Route::put('/{id}', 'update')->name('posts.update')->middleware('permission:posts.update');
    Route::patch('/{id}/status', 'updateStatus')->name('posts.updateStatus')->middleware('permission:posts.updateStatus');
    Route::get('/delete/{id}', 'destroy')->name('posts.destroy');
    Route::get('/restore/{id}', 'restore')->name('posts.restore');
});

// Login Routes
Route::get('/admin/login', [LoginController::class, 'loginForm'])->name('admin.login.view');
Route::post('/login', [LoginController::class, 'login'])->name('admin.login');


Route::middleware(['auth', 'role:Admin'])->prefix('admin')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard')->middleware('permission:dashboard.view');
    // Notification
    Route::post('/notification/read', [DashboardController::class, 'readSingleNotification'])->name('admin.notification.read');
    Route::get('/notification/read-all', [DashboardController::class, 'readAllNotification'])->name('admin.notification.read-all');
    Route::get('/notifications/load-more', [DashboardController::class, 'loadMoreNotifications'])->name('admin.notifications.load-more');


    // Logout

    // General Setting
    Route::get('/settings/general', [GeneralSettingController::class, 'index'])->name('general-settings.index')->middleware('permission:general-settings.index');
    Route::put('/settings/logo', [GeneralSettingController::class, 'updateLogo'])->name('general-settings.update.logo')->middleware('permission:general-settings.update.logo');
    Route::put('/settings/fabicon', [GeneralSettingController::class, 'updateFabicon'])->name('general-settings.update.fabicon')->middleware('permission:general-settings.update.fabicon');
    Route::put('/settings/footerlogo', [GeneralSettingController::class, 'updateFooterLogo'])->name('general-settings.update.footerlogo')->middleware('permission:general-settings.update.footerlogo');
    Route::put('/settings/additional', [GeneralSettingController::class, 'updateAdditional'])->name('general-settings.update.additional')->middleware('permission:general-settings.update.additional');
    Route::put('/settings/social', [GeneralSettingController::class, 'updateSocial'])->name('general-settings.update.social-links')->middleware('permission:general-settings.update.social-links');
    Route::put('/settings/downloadlinks', [GeneralSettingController::class, 'updateDownloadableLink'])->name('general-settings.update.downloadlink')->middleware('permission:general-settings.update.downloadlink');
    Route::put('/settings/mail', [GeneralSettingController::class, 'updateMail'])->name('general-settings.update.mail')->middleware('permission:general-settings.update.mail');
    Route::put('/sms', [GeneralSettingController::class, 'updateSMS'])->name('general-settings.update.sms')->middleware('permission:general-settings.update.sms');

    // Business Settings
    Route::get('/settings/business', [BusinessSettingController::class, 'index'])->name('business-settings.index')->middleware('permission:business-settings.index');
    Route::post('/settings/business', [BusinessSettingController::class, 'update'])->name('business-settings.update')->middleware('permission:business-settings.update');

    // Brand Route
    Route::get('/brand/index', [BrandController::class, 'index'])->name('brand.index')->middleware('permission:brand.index');
    Route::get('/brand/show/{id}', [BrandController::class, 'show'])->name('brand.show')->middleware('permission:brand.show');
    Route::get('/brand/create', [BrandController::class, 'create'])->name('brand.create')->middleware('permission:brand.create');
    Route::post('/brand/store', [BrandController::class, 'store'])->name('brand.store')->middleware('permission:brand.store');
    Route::get('brand/edit/{id}', [BrandController::class, 'edit'])->name('brand.edit')->middleware('permission:brand.edit');
    Route::put('brand/update/{id}', [BrandController::class, 'update'])->name('brand.update')->middleware('permission:brand.update');
    Route::get('brand/delete/{id}', [BrandController::class, 'destroy'])->name('brand.destroy')->middleware('permission:brand.destroy');

    //Announcement
    Route::get('announcements/index', [AnnouncementController::class, 'index'])->name('announcements.index')->middleware('permission:announcements.index');
    Route::get('announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create')->middleware('permission:announcements.create');
    Route::post('announcements/store', [AnnouncementController::class, 'store'])->name('announcements.store')->middleware('permission:announcements.store');
    Route::get('announcements/{id}/show', [AnnouncementController::class, 'show'])->name('announcements.show')->middleware('permission:announcements.show');
    Route::get('announcements/{id}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit')->middleware('permission:announcements.edit');
    Route::put('announcements/{id}', [AnnouncementController::class, 'update'])->name('announcements.update')->middleware('permission:announcements.update');
    Route::get('announcements/{id}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy')->middleware('permission:announcements.destroy');

    // Contact or Support Ticket
    Route::get('contact/index', [ContactController::class, 'index'])->name('contact.index')->middleware('permission:contact.index');
    Route::get('contact/{id}/show', [ContactController::class, 'show'])->name('contact.show')->middleware('permission:contact.show');
    Route::get('contact/delete/{id}', [ContactController::class, 'destroy'])->name('contact.destroy')->middleware('permission:contact.destroy');
    Route::post('contact/store', [ContactController::class, 'store'])->name('contact.store')->middleware('permission:contact.store');

    // Barter Offers Management
    Route::prefix('offers')->name('admin.offers.')->controller(\App\Http\Controllers\Admin\OfferManagementController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{offer}', 'show')->name('show');
        Route::delete('/{offer}', 'destroy')->name('destroy');
        Route::patch('/{offer}/force-cancel', 'forceCancel')->name('force-cancel');
    });
});

Route::prefix('roles/')->controller(RoleController::class)->name('roles.')->group(function () {
    Route::get('/', 'index')->name('index')->middleware('permission:roles.index');
    Route::get('/create', 'create')->name('create')->middleware('permission:roles.create');
    Route::post('/store', 'store')->name('store')->middleware('permission:roles.store');
    Route::get('/edit/{id}', 'edit')->name('edit')->middleware('permission:roles.edit');
    Route::put('/update/{id}', 'update')->name('update')->middleware('permission:roles.update');
    Route::get('/show/{id}', 'show')->name('show')->middleware('permission:roles.show');
    Route::get('/destroy/{id}', 'destroy')->name('destroy')->middleware('permission:roles.destroy');
});


Route::controller(BoostPlanController::class)->group(function () {
    Route::get('/plans', 'index')->name('plans.index')->middleware('permission:plans.index');
    Route::get('/plans/create', 'create')->name('plans.create')->middleware('permission:plans.create');
    Route::post('/plans', 'store')->name('plans.store')->middleware('permission:plans.store');
    Route::get('/plans/sold', 'sold')->name('plans.sold')->middleware('permission:plans.sold');
    Route::get('/plans/trash', 'trash')->name('plans.trash')->middleware('permission:plans.trash');
    Route::get('/plans/{plan}', 'show')->name('plans.show')->middleware('permission:plans.show');
    Route::get('/plans/{plan}/edit', 'edit')->name('plans.edit')->middleware('permission:plans.edit');
    Route::put('/plans/{plan}', 'update')->name('plans.update')->middleware('permission:plans.update');
    Route::get('/plans/delete/{plan}', 'destroy')->name('plans.destroy')->middleware('permission:plans.destroy');
});

/*
// Transactions Routes
Route::controller(TransactionController::class)->group(function () {
    Route::get('/transactions/{status?}', 'index')->name('transactions.index')->middleware('permission:transactions.index');
    Route::get('/wallet-transactions', 'wallet')->name('transactions.wallet');
    Route::get('/wallet-recherge', 'walletRecherge')->name('transactions.walletRecherge');
    Route::get('/direct-boost-transactions', 'boost')->name('transactions.boost');
});
*/



Route::controller(CategoryController::class)->group(function () {
    Route::get('/category', 'index')->name('category.index');
    Route::get('/category/create', 'create')->name('category.create')->middleware('permission:category.create');
    Route::post('/category/store', 'store')->name('category.store')->middleware('permission:category.store');
    Route::get('/category/{category}/show', 'show')->name('category.show')->middleware('permission:category.show');
    Route::get('/category/{category}/edit', 'edit')->name('category.edit')->middleware('permission:category.edit');
    Route::put('/category/{category}', 'update')->name('category.update')->middleware('permission:category.update');
    Route::get('/category/{category}', 'delete')->name('category.destroy')->middleware('permission:category.destroy');
    Route::put('/category/{category}/toggle-status', 'toggleStatus')->name('category.toggleStatus')->middleware('permission:category.toggleStatus');
});

Route::controller(ColorController::class)->group(function () {
    Route::get('/colors', 'index')->name('colors.index')->middleware('permission:colors.index');
    Route::get('/colors/create', 'create')->name('colors.create')->middleware('permission:colors.create');
    Route::post('/colors/store', 'store')->name('colors.store')->middleware('permission:colors.store');
    Route::get('/colors/{colors}/show', 'show')->name('colors.show')->middleware('permission:colors.show');
    Route::get('/colors/{colors}/edit', 'edit')->name('colors.edit')->middleware('permission:colors.edit');
    Route::put('/colors/{colors}', 'update')->name('colors.update')->middleware('permission:colors.update');
    Route::get('/colors/{colors}', 'destroy')->name('colors.destroy')->middleware('permission:colors.destroy');
});

Route::controller(AttributeController::class)->group(function () {
    Route::get('/attributes', 'index')->name('attributes.index')->middleware('permission:attributes.index');
    Route::get('/attributes/create', 'create')->name('attributes.create')->middleware('permission:attributes.create');
    Route::post('/attributes/store', 'store')->name('attributes.store')->middleware('permission:attributes.store');
    Route::get('/attributes/{attributes}/show', 'show')->name('attributes.show')->middleware('permission:attributes.show');
    Route::get('/attributes/{attributes}/edit', 'edit')->name('attributes.edit')->middleware('permission:attributes.edit');
    Route::put('/attributes/{attributes}', 'update')->name('attributes.update')->middleware('permission:attributes.update');
    Route::delete('/attributes/{attributes}', 'destroy')->name('attributes.destroy')->middleware('permission:attributes.destroy');
});

Route::controller(BannerController::class)->group(function () {
    Route::get('/banners', 'index')->name('banners.index')->middleware('permission:banners.index');
    Route::post('/banners/remove-image', 'removeImage')->name('banners.remove-image');
    Route::put('/banners/{id}', 'update')->name('banners.update')->middleware('permission:banners.update');
});

Route::controller(ThemeController::class)->group(function () {
    Route::get('/theme', 'index')->name('theme.index')->middleware('permission:theme.index');
    Route::post('/theme/update', 'update')->name('theme.update')->middleware('permission:theme.update');
});


Route::controller(FastSellingController::class)->group(function () {
    Route::get('/fast-selling', 'index')->name('fast-selling.index')->middleware('permission:fast-selling.index');
    Route::get('/fast-selling/{id}/edit', 'edit')->name('fast-selling.edit')->middleware('permission:fast-selling.edit');
    Route::put('/fast-selling/{id}', 'update')->name('fast-selling.update')->middleware('permission:fast-selling.update');
});


Route::prefix('pages')->controller(LegalPageController::class)->name('pages.')->group(function () {
    Route::get('/show/{slug}', 'show')->name('show');
    Route::post('legal-pages/update/{section}', 'updatePage')->name('update');
});



Route::controller(TestimonialController::class)->group(function () {
    Route::get('/testimonials', 'index')->name('testimonials.index')->middleware('permission:testimonials.index');
    Route::get('/testimonials/create', 'create')->name('testimonials.create')->middleware('permission:testimonials.create');
    Route::post('/testimonials/store', 'store')->name('testimonials.store')->middleware('permission:testimonials.store');
    Route::get('/testimonials/{id}/show', 'show')->name('testimonials.show')->middleware('permission:testimonials.show');
    Route::get('/testimonials/{id}/edit', 'edit')->name('testimonials.edit')->middleware('permission:testimonials.edit');
    Route::put('/testimonials/{id}/update', 'update')->name('testimonials.update')->middleware('permission:testimonials.update');
    Route::get('/testimonials/{id}/delete', 'destroy')->name('testimonials.destroy')->middleware('permission:testimonials.destroy');
});

Route::controller(ServiceController::class)->group(function () {
    Route::get('/services', 'index')->name('services.index')->middleware('permission:services.index');
    Route::post('/services/store', 'store')->name('services.store')->middleware('permission:services.store');
    Route::get('/services/{id}/show', 'show')->name('services.show')->middleware('permission:services.show');
    Route::get('/services/{id}/edit', 'edit')->name('services.edit')->middleware('permission:services.edit');
    Route::post('/services/{id}/update', 'update')->name('services.update')->middleware('permission:services.update');
    Route::post('/services/{id}/delete', 'destroy')->name('services.destroy')->middleware('permission:services.destroy');
    Route::post('/services/update-status', 'updateStatus')->name('services.updateStatus');
});

Route::controller(LanguageController::class)->group(function () {
    Route::get('/languages', 'index')->name('languages.index')->middleware('permission:languages.index');
    Route::get('/languages/create', 'create')->name('languages.create')->middleware('permission:languages.create');
    Route::post('/languages/store', 'store')->name('languages.store')->middleware('permission:languages.store');
    Route::get('/languages/{id}/edit', 'edit')->name('languages.edit')->middleware('permission:languages.edit');
    Route::put('/languages/{id}/update', 'update')->name('languages.update')->middleware('permission:languages.update');
    Route::get('/languages/{id}/delete', 'destroy')->name('languages.destroy')->middleware('permission:languages.destroy');
});
Route::controller(PaymentGatewayController::class)->group(function () {
    Route::get('/payment-gateways', 'index')->name('payment-gateways.index')->middleware('permission:payment-gateways.index');
    Route::get('/payment-gateways/create', 'create')->name('payment-gateways.create')->middleware('permission:payment-gateways.create');
    Route::post('/payment-gateways/store', 'store')->name('payment-gateways.store')->middleware('permission:payment-gateways.store');
    Route::get('/payment-gateways/edit/{id}', 'edit')->name('payment-gateways.edit')->middleware('permission:payment-gateways.edit');
    Route::put('/payment-gateways/update/{id}', 'update')->name('payment-gateways.update');
    Route::delete('/payment-gateways/delete/{id}', 'destroy')->name('payment-gateways.destroy')->middleware('permission:payment-gateways.destroy');
});

Route::get('docs/api', function () {
    return;
});


// CMS
Route::controller(CMSController::class)->group(function () {
    Route::get('/cms/footer', 'index')->name('cms-footer.index');
    Route::post('/cms/footer/update-subtite', 'updateSubtitle')->name('cms-footer.update-subtite');
    Route::post('/cms/footer/update-social', 'updateSocial')->name('cms-footer.update-social');
    Route::post('/cms/footer/update/footer-info', 'updateFooterInfo')->name('cms-footer.update-footer-info');
    Route::post('/cms/footer/update-menu-order', 'updateFooterMenuOrder')->name('cms-footer.update-menu-order');
    Route::post('/cms/footer/reset-menu', 'resetFooterMenu')->name('cms-footer.reset-menu');
});

Route::prefix('cms/navigation')->name('cms-navigation.')->controller(NavigationController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/install-defaults', 'installDefaults')->name('install-defaults');
    Route::post('/', 'store')->name('store');
    Route::put('/{navigationItem}', 'update')->name('update');
    Route::delete('/{navigationItem}', 'destroy')->name('destroy');
});
// Moderation Reports
Route::controller(App\Http\Controllers\Admin\ReportController::class)->prefix('reports')->middleware(['auth'])->name('reports.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::delete('/{id}', 'delete')->name('delete');
});
