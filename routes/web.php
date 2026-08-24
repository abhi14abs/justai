<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AffiliateController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PostryxController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Web Routes for Postryx.in
|--------------------------------------------------------------------------
*/

// Homepage
Route::get('/', [PostryxController::class, 'home'])->name('home');

// 12 Programmatic SEO Tool Pages
Route::get('/tools/{slug}', [PostryxController::class, 'tool'])->name('tool.show');

// Pricing & Plans
Route::get('/pricing', [PostryxController::class, 'pricing'])->name('pricing');

// Dedicated Checkout Flow
Route::get('/checkout', [PaymentController::class, 'checkoutPage'])->name('checkout');
Route::get('/checkout/paypal/success', [PaymentController::class, 'capturePayPal'])->name('checkout.paypal.success');

// Blog & Resource Hub
Route::get('/blog', [PostryxController::class, 'blog'])->name('blog.index');
Route::get('/blog/{slug}', [PostryxController::class, 'blogShow'])->name('blog.show');

// Affiliate / Referral Public Page
Route::get('/affiliate', [AffiliateController::class, 'index'])->name('affiliate');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Legal
Route::get('/terms', [PostryxController::class, 'terms'])->name('terms');
Route::get('/privacy', [PostryxController::class, 'privacy'])->name('privacy');

// SEO Assets
Route::get('/sitemap.xml', [PostryxController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [PostryxController::class, 'robots'])->name('robots');

/*
|--------------------------------------------------------------------------
| Protected Member & Affiliate Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // User Member Dashboard & Agency Features
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/api-token', [DashboardController::class, 'generateApiToken'])->name('dashboard.apiToken');
    Route::post('/dashboard/team/add', [DashboardController::class, 'addTeamMember'])->name('dashboard.team.add');
    Route::post('/dashboard/team/{id}/delete', [DashboardController::class, 'removeTeamMember'])->name('dashboard.team.delete');
    Route::post('/dashboard/workspace/add', [DashboardController::class, 'saveBrandWorkspace'])->name('dashboard.workspace.add');
    Route::post('/dashboard/workspace/{id}/delete', [DashboardController::class, 'deleteBrandWorkspace'])->name('dashboard.workspace.delete');

    // Affiliate Partner Dashboard
    Route::get('/affiliate/dashboard', [AffiliateController::class, 'dashboard'])->name('affiliate.dashboard');
    Route::post('/affiliate/settings', [AffiliateController::class, 'savePayoutSettings'])->name('affiliate.settings');
    Route::post('/affiliate/payout-request', [AffiliateController::class, 'requestPayout'])->name('affiliate.requestPayout');

    // Admin Master Control Portal
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/dashboard', [AdminController::class, 'dashboard']);
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::post('/users/{id}/update', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::post('/users/{id}/delete', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
        Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
        Route::get('/affiliates', [AdminController::class, 'affiliates'])->name('admin.affiliates');
        Route::get('/payouts', [AdminController::class, 'payouts'])->name('admin.payouts');
        Route::post('/payouts/{id}/process', [AdminController::class, 'processPayout'])->name('admin.payouts.process');
        Route::get('/generations', [AdminController::class, 'generations'])->name('admin.generations');
        Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');

        // Blog Article CMS
        Route::get('/blogs', [AdminController::class, 'blogs'])->name('admin.blogs');
        Route::get('/blogs/create', [AdminController::class, 'createBlog'])->name('admin.blogs.create');
        Route::post('/blogs/store', [AdminController::class, 'storeBlog'])->name('admin.blogs.store');
        Route::get('/blogs/{id}/edit', [AdminController::class, 'editBlog'])->name('admin.blogs.edit');
        Route::post('/blogs/{id}/update', [AdminController::class, 'updateBlog'])->name('admin.blogs.update');
        Route::post('/blogs/{id}/toggle-status', [AdminController::class, 'toggleBlogStatus'])->name('admin.blogs.toggle');
        Route::post('/blogs/{id}/delete', [AdminController::class, 'deleteBlog'])->name('admin.blogs.delete');
    });
});

/*
|--------------------------------------------------------------------------
| REST API Endpoints (Content Generation & Payments)
|--------------------------------------------------------------------------
*/
Route::prefix('api')->group(function () {
    // Content Generation APIs
    Route::post('/generate', [ApiController::class, 'generate'])->name('api.generate');
    Route::post('/analyze', [ApiController::class, 'analyze'])->name('api.analyze');
    Route::post('/humanize', [ApiController::class, 'humanize'])->name('api.humanize');
    Route::post('/repurpose', [ApiController::class, 'repurpose'])->name('api.repurpose');
    Route::post('/newsletter', [ApiController::class, 'newsletter'])->name('api.newsletter');
    Route::post('/coupon/validate', [ApiController::class, 'validateCoupon'])->name('api.coupon');

    // Real Payment Gateway APIs
    Route::post('/checkout/create-order', [PaymentController::class, 'createOrder'])->name('api.checkout.create');
    Route::post('/checkout/paypal/capture', [PaymentController::class, 'capturePayPal'])->name('api.checkout.paypal.capture');
    Route::post('/checkout/razorpay/verify', [PaymentController::class, 'verifyRazorpay'])->name('api.checkout.razorpay.verify');
    Route::post('/checkout/upi/submit', [PaymentController::class, 'submitUpiPayment'])->name('api.checkout.upi.submit');
});
