<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\Backend\AboutCompanyController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ContactFormController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\FontController;
use App\Http\Controllers\Backend\MissionVisionController;
use App\Http\Controllers\Backend\NewsletterController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SiteSettingsController;
use App\Http\Controllers\BkashDemoController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Artisan;

Route::get('/clear-cache', function () {

    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');

    return redirect()->route('index');
});

// #################### Frontend Controller ####################
Route::middleware('web')->group(function () {
    // Home
    Route::get('/', [FrontendController::class, 'Index'])->name('index');

    // Shop
    Route::get('/shop', [FrontendController::class, 'Shop'])->name('shop');

    // Cart — REMOVED (no cart flow, direct download instead)

    // Product By Category
    Route::get('/category/{slug}', [FrontendController::class, 'ProductByCategory'])->name('product.by.category');

    // Contact Us
    Route::get('/contact', [FrontendController::class, 'Contact'])->name('contact');
    Route::post('/contact/submit', [ContactFormController::class, 'ContactSubmit'])->name('contact.submit');

    // About Us
    Route::get('/about-us', [FrontendController::class, 'AboutUs'])->name('about');

    // Search
    Route::get('/ajax-search', [FrontendController::class, 'ajaxSearch'])->name('ajax.search');

    // Fonts (1001fonts-style library)
    Route::get('/fonts', [FrontendController::class, 'Fonts'])->name('fonts.index');
    Route::get('/fonts/{slug}', [FrontendController::class, 'FontDetail'])->name('fonts.show');
    Route::get('/fonts/{slug}/download', [FrontendController::class, 'FontDownload'])->name('fonts.download');

    // ── Cart — REMOVED (no cart/checkout flow, direct one-click download instead) ──

    // ── Policies ──────────────────────────────────────────────────────────────
    Route::get('/data-usage', [FrontendController::class, 'DataUsage'])->name('data.usage');
    Route::get('/refund-conditions', [FrontendController::class, 'RefundConditions'])->name('refund.conditions');
    Route::get('/shipping-policies', [FrontendController::class, 'ShippingPolicies'])->name('shipping.policies');
    Route::get('/international-returns', [FrontendController::class, 'InternationalReturns'])->name('international.returns');
    Route::get('/return-policy', [FrontendController::class, 'ReturnPolicy'])->name('return.policy');
    Route::get('/terms-conditions', [FrontendController::class, 'TermsConditions'])->name('terms.conditions');
    Route::get('/privacy-policy', [FrontendController::class, 'PrivacyPolicy'])->name('privacy.policy');

    // Checkout tax-rate — REMOVED (no checkout flow)
});

// #################### End: Frontend Controller ####################

require __DIR__ . '/auth.php';

// #################### Admin Controller ####################
Route::middleware('admin')->group(function () {
    // Admin Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');

    // Admin Profile
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');

    // ── Categories ────────────────────────────────────────────────────────────────
    Route::prefix('backend/categories')
        ->name('backend.categories.')
        ->group(function () {
            Route::get('/list', [CategoryController::class, 'CategoryList'])->name('list');
            Route::get('/add', [CategoryController::class, 'CategoryAdd'])->name('add');
            Route::post('/store', [CategoryController::class, 'CategoryStore'])->name('store');
            Route::get('/edit/{id}', [CategoryController::class, 'CategoryEdit'])->name('edit');
            Route::post('/update', [CategoryController::class, 'CategoryUpdate'])->name('update');
            Route::get('/delete/{id}', [CategoryController::class, 'CategoryDelete'])->name('delete');
            Route::post('/ajax-store', [CategoryController::class, 'CategoryAjaxStore'])->name('ajax_store'); // ← NEW
        });

    // ── Products ──────────────────────────────────────────────────────────────────
    Route::prefix('backend/products')
        ->name('backend.products.')
        ->group(function () {
            Route::get('/list', [ProductController::class, 'ProductList'])->name('list');
            Route::get('/add', [ProductController::class, 'ProductAdd'])->name('add');
            Route::post('/store', [ProductController::class, 'ProductStore'])->name('store');
            Route::get('/edit/{id}', [ProductController::class, 'ProductEdit'])->name('edit');
            Route::post('/update', [ProductController::class, 'ProductUpdate'])->name('update');
            Route::get('/delete/{id}', [ProductController::class, 'ProductDelete'])->name('delete');
        });

    // ── Fonts ─────────────────────────────────────────────────────────────────────
    Route::prefix('backend/fonts')
        ->name('backend.fonts.')
        ->group(function () {
            Route::get('/list', [FontController::class, 'FontList'])->name('list');
            Route::get('/add', [FontController::class, 'FontAdd'])->name('add');
            Route::post('/store', [FontController::class, 'FontStore'])->name('store');
            Route::get('/edit/{id}', [FontController::class, 'FontEdit'])->name('edit');
            Route::post('/update', [FontController::class, 'FontUpdate'])->name('update');
            Route::get('/delete/{id}', [FontController::class, 'FontDelete'])->name('delete');
        });

    // About Our Company
    Route::get('/backend/about-company/list', [AboutCompanyController::class, 'AboutCompanyList'])->name('backend.about_company.list');
    Route::get('/backend/about-company/edit/{id}', [AboutCompanyController::class, 'AboutCompanyEdit'])->name('backend.about_company.edit');
    Route::post('/backend/about-company/update', [AboutCompanyController::class, 'AboutCompanyUpdate'])->name('backend.about_company.update');

    // Mission, Vision, Values
    Route::get('/backend/mission-vision-values/list', [MissionVisionController::class, 'MissionVisionList'])->name('backend.mission_vision.list');
    Route::get('/backend/mission-vision-values/edit/{id}', [MissionVisionController::class, 'MissionVisionEdit'])->name('backend.mission_vision.edit');
    Route::post('/backend/mission-vision-values/update', [MissionVisionController::class, 'MissionVisionUpdate'])->name('backend.mission_vision.update');

    // Contact Form
    Route::get('/backend/contact-form/list', [ContactFormController::class, 'ContactFormList'])->name('backend.contact_form.list');
    Route::get('/backend/contact-form/delete/{id}', [ContactFormController::class, 'ContactFormDelete'])->name('backend.contact_form.delete');
    Route::post('/backend/contact-form/bulk-delete', [ContactFormController::class, 'ContactFormBulkDelete'])->name('backend.contact_form.bulk_delete');

    Route::prefix('backend/newsletter')
        ->name('backend.newsletter.')
        ->group(function () {
            Route::get('/list', [NewsletterController::class, 'NewsletterList'])->name('list');
            Route::get('/delete/{id}', [NewsletterController::class, 'NewsletterDelete'])->name('delete');
            Route::post('/bulk-delete', [NewsletterController::class, 'NewsletterBulkDelete'])->name('bulk_delete');
            Route::get('/export', [NewsletterController::class, 'NewsletterExport'])->name('export');
            Route::post('/newsletter/toggle-status', [NewsletterController::class, 'ToggleStatus'])->name('toggle_status');
        });

    Route::prefix('backend/customers')
        ->name('backend.customers.')
        ->group(function () {
            Route::get('/list', [CustomerController::class, 'CustomerList'])->name('list');
            Route::get('/add', [CustomerController::class, 'CustomerAdd'])->name('add');
            Route::post('/store', [CustomerController::class, 'CustomerStore'])->name('store');
            Route::get('/edit/{id}', [CustomerController::class, 'CustomerEdit'])->name('edit');
            Route::post('/update', [CustomerController::class, 'CustomerUpdate'])->name('update');
            Route::get('/detail/{id}', [CustomerController::class, 'CustomerDetail'])->name('detail');
            Route::post('/toggle-status', [CustomerController::class, 'ToggleStatus'])->name('toggle_status');
            Route::get('/delete/{id}', [CustomerController::class, 'CustomerDelete'])->name('delete');
            Route::post('/bulk-delete', [CustomerController::class, 'CustomerBulkDelete'])->name('bulk_delete');
        });

    // Font Awesome
    Route::get('/backend/site-settings/font-awesome', [SiteSettingsController::class, 'FontAwesome'])->name('backend.site_settings.font_awesome');

    // Site Settings
    Route::get('/backend/site-settings', [SiteSettingsController::class, 'SiteSettings'])->name('backend.site_settings');
    Route::post('/backend/site-settings/update', [SiteSettingsController::class, 'SiteSettingsUpdate'])->name('backend.site_settings.update');

    // Status Update
    Route::post('/backend/status-update', [GlobalController::class, 'StatusUpdate'])->name('backend.status.update');
});

Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');
Route::post('/admin/login/submit', [AdminController::class, 'AdminLoginSubmit'])->name('admin.login.submit');
Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
Route::get('/admin/forget/password', [AdminController::class, 'AdminForgetPassword'])->name('admin.forget.password');
Route::post('/admin/forget/password/submit', [AdminController::class, 'AdminForgetPasswordSubmit'])->name('admin.forget.password.submit');
Route::get('/admin/reset/password/{token}/{email}', [AdminController::class, 'AdminResetPassword']);
Route::post('/admin/forget/reset/submit', [AdminController::class, 'AdminResetPasswordSubmit'])->name('admin.reset.password.submit');
// #################### End: Admin Controller ####################

/*
|--------------------------------------------------------------------------
| Customer Authentication
|--------------------------------------------------------------------------
*/
Route::middleware('guest.customer')->group(function () {
    Route::get('/login', [CustomerAuthController::class, 'login'])->name('customer.login');
    Route::post('/login/submit', [CustomerAuthController::class, 'loginSubmit'])->name('customer.login.submit');

    Route::get('/register', [CustomerAuthController::class, 'register'])->name('customer.register');
    Route::post('/register/submit', [CustomerAuthController::class, 'registerSubmit'])->name('customer.register.submit');

    Route::get('/forgot-password', [CustomerAuthController::class, 'forgotPassword'])->name('password.request');
    Route::post('/forgot-password', [CustomerAuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [CustomerAuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [CustomerAuthController::class, 'resetPassword'])->name('password.update');
});

Route::get('/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');

// bKash redirects here after payment — must stay outside 'customer' middleware group
// since it's bKash's server-side redirect, not an authenticated app request.
Route::get('/payment/bkash/callback', [BkashDemoController::class, 'callback'])->name('customer.payment.bkash.callback');

/*
|--------------------------------------------------------------------------
| Protected Customer Routes
|--------------------------------------------------------------------------
*/
// ─── Protected Customer Routes (login required) ───────────────────────────
Route::middleware('customer')->group(function () {
    Route::get('/dashboard', [CustomerAuthController::class, 'dashboard'])->name('customer.dashboard');
    Route::get('/profile', [CustomerAuthController::class, 'profile'])->name('customer.profile');
    Route::post('/profile/update', [CustomerAuthController::class, 'profileUpdate'])->name('customer.profile.update');
    Route::get('/downloads', [CustomerAuthController::class, 'downloads'])->name('customer.downloads');
    Route::get('/payment', [CustomerAuthController::class, 'payment'])->name('customer.payment');

    // ── bKash Tokenized Checkout (real sandbox API) ──
    Route::post('/payment/bkash/initiate', [BkashDemoController::class, 'initiate'])->name('customer.payment.bkash.initiate');
    Route::post('/change/password', [CustomerAuthController::class, 'changePassword'])->name('customer.password.change');

    Route::post('/download/{slug}', [DownloadController::class, 'download'])->name('product.download');
    Route::get('/download/remaining/check', [DownloadController::class, 'remaining'])->name('product.download.remaining');

    // ── Wishlist (logged-in customers only) ─────────────────────────────────
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('customer.wishlist');
    Route::get('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
});

// ─── Checkout Routes — REMOVED (no cart, no checkout; direct one-click download after login) ───


Route::fallback(function () {
    $url = request()->path();

    if (str_starts_with($url, 'admin') || str_starts_with($url, 'backend')) {
        return response()->view('admin.errors.404', [], 404);
    }

    return response()->view('frontend.errors.404', [], 404);
});

Route::post('/newsletter/subscribe', [FrontendController::class, 'subscribe'])->name('newsletter.subscribe');

Route::get('/newsletter/unsubscribe/{token}', [FrontendController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

// Stripe webhook — REMOVED (no checkout/payment gateway flow)