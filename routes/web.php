<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\Backend\AboutCompanyController;
use App\Http\Controllers\Backend\AuthorController;
use App\Http\Controllers\Backend\BlogCategoriesController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\BulkOrderController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ContactFormController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\MissionVisionController;
use App\Http\Controllers\Backend\NewsletterController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductReviewController;
use App\Http\Controllers\Backend\SiteSettingsController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

// #################### Frontend Controller ####################
Route::middleware('web')->group(function () {
    // Home
    Route::get('/', [FrontendController::class, 'Index'])->name('index');

    // Shop
    Route::get('/shop', [FrontendController::class, 'Shop'])->name('shop');

    // Cart — REMOVED (no cart flow, direct download instead)

    // Product Details
    Route::get('/product/{slug}', [FrontendController::class, 'ProductDetails'])->name('product.details');

    // Product Review
    Route::post('/product/review', [ProductReviewController::class, 'storeReview'])->name('product.review.store');

    // Bulk Order Submit
    Route::post('/bulk-order-submit', [FrontendController::class, 'bulkOrderSubmit'])->name('bulk.order.submit');

    // Product By Category
    Route::get('/category/{slug}', [FrontendController::class, 'ProductByCategory'])->name('product.by.category');

    // Product By Sub-Category
    Route::get('/sub-category/{slug}', [FrontendController::class, 'ProductBySubCategory'])->name('product.by.subcategory');

    // Product By Age
    Route::get('/age/{slug}', [FrontendController::class, 'ProductByAge'])->name('product.by.age');

    // Contact Us
    Route::get('/contact', [FrontendController::class, 'Contact'])->name('contact');
    Route::post('/contact/submit', [ContactFormController::class, 'ContactSubmit'])->name('contact.submit');

    // Blog
    Route::get('/blog', [FrontendController::class, 'Blog'])->name('blog');
    Route::get('/blog/search', [FrontendController::class, 'BlogSearch'])->name('blog.search');

    // ✅ Submit routes — wildcard এর আগে (middleware আলাদাভাবে apply)
    Route::get('/blog/submit', [FrontendController::class, 'BlogSubmitForm'])
        ->name('blog.submit')
        ->middleware('customer');
    Route::post('/blog/submit', [FrontendController::class, 'BlogSubmitStore'])
        ->name('blog.submit.store')
        ->middleware('customer');

    // Wildcard সবার শেষে
    Route::get('/blog/{slug}', [FrontendController::class, 'BlogDetails'])->name('blog.details');

    // About Us
    Route::get('/about-us', [FrontendController::class, 'AboutUs'])->name('about');

    // Search
    Route::get('/ajax-search', [FrontendController::class, 'ajaxSearch'])->name('ajax.search');

    // Child Development
    Route::get('/child-development', [FrontendController::class, 'ChildDevelopment'])->name('child.development');

    // Wholesale
    Route::get('/wholesale', [FrontendController::class, 'WholesaleProducts'])->name('wholesale');

    Route::get('/product/quick-view/{id}', [FrontendController::class, 'quickView'])->name('product.quick-view');

    // ── Cart — REMOVED (no cart/checkout flow, direct one-click download instead) ──

    // ── Policies ──────────────────────────────────────────────────────────────
    Route::get('/data-usage', [FrontendController::class, 'DataUsage'])->name('data.usage');
    Route::get('/refund-conditions', [FrontendController::class, 'RefundConditions'])->name('refund.conditions');
    Route::get('/shipping-policies', [FrontendController::class, 'ShippingPolicies'])->name('shipping.policies');
    Route::get('/international-returns', [FrontendController::class, 'InternationalReturns'])->name('international.returns');
    Route::get('/return-policy', [FrontendController::class, 'ReturnPolicy'])->name('return.policy');
    Route::get('/terms-conditions', [FrontendController::class, 'TermsConditions'])->name('terms.conditions');
    Route::get('/privacy-policy', [FrontendController::class, 'PrivacyPolicy'])->name('privacy.policy');

    // ── Public: Submit Review (outside admin middleware) ──────────────────────────
    // Route::post('/product/review', [ProductReviewController::class, 'storeReview'])->name('product.review.store');

    // Product By Author
    Route::get('/author/{slug}', [FrontendController::class, 'ProductByAuthor'])->name('product.by.author');

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

    // Slider Controller
    Route::get('/backend/slider/list', [SliderController::class, 'SliderList'])->name('backend.slider.list');
    Route::get('/backend/slider/add', [SliderController::class, 'SliderAdd'])->name('backend.slider.add');
    Route::post('/backend/slider/store', [SliderController::class, 'SliderStore'])->name('backend.slider.store');
    Route::get('/backend/slider/edit/{id}', [SliderController::class, 'SliderEdit'])->name('backend.slider.edit');
    Route::post('/backend/slider/update', [SliderController::class, 'SliderUpdate'])->name('backend.slider.update');
    Route::get('/backend/slider/delete/{id}', [SliderController::class, 'SliderDelete'])->name('backend.slider.delete');

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

    // ── Authors ───────────────────────────────────────────────────────────────────
    Route::prefix('backend/authors')
        ->name('backend.authors.')
        ->group(function () {
            Route::get('/list', [AuthorController::class, 'AuthorList'])->name('list');
            Route::get('/add', [AuthorController::class, 'AuthorAdd'])->name('add');
            Route::post('/store', [AuthorController::class, 'AuthorStore'])->name('store');
            Route::get('/edit/{id}', [AuthorController::class, 'AuthorEdit'])->name('edit');
            Route::post('/update', [AuthorController::class, 'AuthorUpdate'])->name('update');
            Route::get('/delete/{id}', [AuthorController::class, 'AuthorDelete'])->name('delete');
            Route::get('/search', [AuthorController::class, 'AuthorSearch'])->name('search');
            Route::post('/ajax-store', [AuthorController::class, 'AuthorAjaxStore'])->name('ajax_store'); // ← NEW
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
            Route::post('/gallery/update/{id}', [ProductController::class, 'GalleryImageUpdate'])->name('gallery.update');
            Route::delete('/gallery/delete/{id}', [ProductController::class, 'GalleryImageDelete'])->name('gallery.delete');
        });

    // ── Product Reviews ───────────────────────────────────────────────────────────
    Route::prefix('backend/product-reviews')
        ->name('backend.reviews.')
        ->group(function () {
            Route::get('/list', [ProductReviewController::class, 'ProductReviewList'])->name('list');
            Route::post('/update-status', [ProductReviewController::class, 'updateStatus'])->name('update_status');
            Route::get('/delete/{id}', [ProductReviewController::class, 'ProductReviewDelete'])->name('delete');
            Route::post('/bulk-delete', [ProductReviewController::class, 'ProductReviewBulkDelete'])->name('bulk_delete');
        });

    // About Our Company
    Route::get('/backend/about-company/list', [AboutCompanyController::class, 'AboutCompanyList'])->name('backend.about_company.list');
    Route::get('/backend/about-company/edit/{id}', [AboutCompanyController::class, 'AboutCompanyEdit'])->name('backend.about_company.edit');
    Route::post('/backend/about-company/update', [AboutCompanyController::class, 'AboutCompanyUpdate'])->name('backend.about_company.update');

    // Mission, Vision, Values
    Route::get('/backend/mission-vision-values/list', [MissionVisionController::class, 'MissionVisionList'])->name('backend.mission_vision.list');
    Route::get('/backend/mission-vision-values/edit/{id}', [MissionVisionController::class, 'MissionVisionEdit'])->name('backend.mission_vision.edit');
    Route::post('/backend/mission-vision-values/update', [MissionVisionController::class, 'MissionVisionUpdate'])->name('backend.mission_vision.update');

    // Blog Categories
    Route::get('/backend/blog-categories/list', [BlogCategoriesController::class, 'BlogCategoriesList'])->name('backend.blog_categories.list');
    Route::get('/backend/blog-categories/add', [BlogCategoriesController::class, 'BlogCategoriesAdd'])->name('backend.blog_categories.add');
    Route::post('/backend/blog-categories/store', [BlogCategoriesController::class, 'BlogCategoriesStore'])->name('backend.blog_categories.store');
    Route::get('/backend/blog-categories/edit/{id}', [BlogCategoriesController::class, 'BlogCategoriesEdit'])->name('backend.blog_categories.edit');
    Route::post('/backend/blog-categories/update', [BlogCategoriesController::class, 'BlogCategoriesUpdate'])->name('backend.blog_categories.update');
    Route::get('/backend/blog-categories/delete/{id}', [BlogCategoriesController::class, 'BlogCategoriesDelete'])->name('backend.blog_categories.delete');
    // Blog Categories (AJAX)
    Route::post('/backend/blog-categories/ajax-store', [BlogCategoriesController::class, 'BlogCategoriesAjaxStore'])->name('backend.blog_categories.ajax_store');

    // Blog
    Route::get('/backend/blog/list', [BlogController::class, 'BlogList'])->name('backend.blog.list');
    Route::get('/backend/blog/add', [BlogController::class, 'BlogAdd'])->name('backend.blog.add');
    Route::post('/backend/blog/store', [BlogController::class, 'BlogStore'])->name('backend.blog.store');
    Route::get('/backend/blog/edit/{id}', [BlogController::class, 'BlogEdit'])->name('backend.blog.edit');
    Route::post('/backend/blog/update', [BlogController::class, 'BlogUpdate'])->name('backend.blog.update');
    Route::get('/backend/blog/delete/{id}', [BlogController::class, 'BlogDelete'])->name('backend.blog.delete');
    Route::get('/backend/blog/{id}/content', [BlogController::class, 'BlogContent'])->name('backend.blog.content');
    // Blog approve / reject (AJAX)
    Route::post('/backend/blog/{id}/approve', [BlogController::class, 'BlogApprove'])->name('backend.blog.approve');
    Route::post('/backend/blog/{id}/reject', [BlogController::class, 'BlogReject'])->name('backend.blog.reject');

    // Contact Form
    Route::get('/backend/contact-form/list', [ContactFormController::class, 'ContactFormList'])->name('backend.contact_form.list');
    Route::get('/backend/contact-form/delete/{id}', [ContactFormController::class, 'ContactFormDelete'])->name('backend.contact_form.delete');
    Route::post('/backend/contact-form/bulk-delete', [ContactFormController::class, 'ContactFormBulkDelete'])->name('backend.contact_form.bulk_delete');

    // Coupon
    Route::get('/backend/coupon/list', [CouponController::class, 'CouponList'])->name('backend.coupon.list');
    Route::get('/backend/coupon/add', [CouponController::class, 'CouponAdd'])->name('backend.coupon.add');
    Route::post('/backend/coupon/store', [CouponController::class, 'CouponStore'])->name('backend.coupon.store');
    Route::get('/backend/coupon/edit/{id}', [CouponController::class, 'CouponEdit'])->name('backend.coupon.edit');
    Route::post('/backend/coupon/update', [CouponController::class, 'CouponUpdate'])->name('backend.coupon.update');
    Route::get('/backend/coupon/delete/{id}', [CouponController::class, 'CouponDelete'])->name('backend.coupon.delete');
    Route::get('/backend/coupon/generate-code', [CouponController::class, 'generateCode'])->name('backend.coupon.generate');

    Route::prefix('backend/orders')
        ->name('backend.orders.')
        ->group(function () {
            Route::get('/list', [OrderController::class, 'OrderList'])->name('list');
            Route::get('/{id}/invoice', [OrderController::class, 'DownloadInvoice'])->name('invoice'); // ← NEW
            Route::get('/{id}', [OrderController::class, 'OrderDetail'])->name('detail');
            Route::post('/{id}/status', [OrderController::class, 'UpdateStatus'])->name('status.update');
            Route::post('/{id}/payment-status', [OrderController::class, 'UpdatePaymentStatus'])->name('payment.status.update');
            Route::get('/delete/{id}', [OrderController::class, 'OrderDelete'])->name('delete');
        });

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

/*
|--------------------------------------------------------------------------
| Protected Customer Routes
|--------------------------------------------------------------------------
*/
// ─── Protected Customer Routes (login required) ───────────────────────────
Route::middleware('customer')->group(function () {
    Route::get('/dashboard', [CustomerAuthController::class, 'dashboard'])->name('customer.dashboard');
    Route::post('/profile/update', [CustomerAuthController::class, 'profileUpdate'])->name('customer.profile.update');
    Route::post('/change/password', [CustomerAuthController::class, 'changePassword'])->name('customer.password.change');
    Route::get('/my-orders', [CheckoutController::class, 'myOrders'])->name('customer.orders');
    Route::get('/order/{id}/invoice', [CheckoutController::class, 'downloadInvoice'])->name('customer.order.invoice');

    // ✅ এই line টা যোগ করুন
    Route::get('/my-blogs', [CustomerAuthController::class, 'myBlogs'])->name('customer.blogs');

    Route::get('/blog/edit/{id}', [FrontendController::class, 'BlogEditForm'])
        ->name('blog.edit')
        ->middleware('customer');
    Route::post('/blog/edit/{id}', [FrontendController::class, 'BlogEditStore'])
        ->name('blog.edit.store')
        ->middleware('customer');

    Route::get('/download/{slug}', [DownloadController::class, 'download'])->name('product.download');
    Route::get('/download/remaining/check', [DownloadController::class, 'remaining'])->name('product.download.remaining');
});

// ─── Checkout Routes — REMOVED (no cart, no checkout; direct one-click download after login) ───


Route::fallback(function () {
    $url = request()->path();

    if (str_starts_with($url, 'admin') || str_starts_with($url, 'backend')) {
        return response()->view('admin.errors.404', [], 404);
    }

    return response()->view('frontend.errors.404', [], 404);
});

// Wishlist — REMOVED (no cart/wishlist flow, direct download instead)

Route::post('/newsletter/subscribe', [FrontendController::class, 'subscribe'])->name('newsletter.subscribe');

Route::get('/newsletter/unsubscribe/{token}', [FrontendController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

// Stripe webhook — REMOVED (no checkout/payment gateway flow)

