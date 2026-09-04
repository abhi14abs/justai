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

/*
|--------------------------------------------------------------------------
| Digital Invitation Platform Routes (CelebrateAI)
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Invitations\InvitationBrowseController;
use App\Http\Controllers\Invitations\InvitationBuilderController;
use App\Http\Controllers\Invitations\InvitationCheckoutController;
use App\Http\Controllers\Invitations\InvitationDashboardController;
use App\Http\Controllers\Invitations\InvitationPublicController;
use App\Http\Controllers\Invitations\Admin\InvitationAdminController;
use App\Http\Controllers\Invitations\Api\InvitationApiController;

// 1. Public Marketplace & Browsing
Route::get('/invitations', [InvitationBrowseController::class, 'index'])->name('invitations.browse.index');
Route::get('/invitations/category/{slug}', [InvitationBrowseController::class, 'category'])->name('invitations.browse.category');
Route::get('/invitations/preview/{slug}', [InvitationBrowseController::class, 'preview'])->name('invitations.browse.preview');

// 2. Public Live Invitations & RSVPs (Mobile-First Slug URLs)
Route::get('/i/{slug}', [InvitationPublicController::class, 'show'])->name('invitations.public.show');
Route::post('/i/{slug}/rsvp', [InvitationPublicController::class, 'submitRsvp'])->name('invitations.public.rsvp');
Route::post('/i/{slug}/share/{channel}', [InvitationPublicController::class, 'trackShare'])->name('invitations.public.share');
Route::post('/i/{slug}/memories/upload', [InvitationPublicController::class, 'uploadMemory'])->name('invitations.public.memories.upload');
Route::get('/i/{slug}/memories', [InvitationPublicController::class, 'getMemories'])->name('invitations.public.memories.list');

// 3. Customer Builder & Member Dashboard Routes (Protected)
Route::middleware(['auth'])->group(function () {
    // Builder
    Route::get('/invitations/builder/{templateSlug}/create', [InvitationBuilderController::class, 'createFromTemplate'])->name('invitations.builder.create');
    Route::get('/invitations/builder/{id}', [InvitationBuilderController::class, 'edit'])->name('invitations.builder.edit');
    Route::post('/invitations/builder/{id}/update', [InvitationBuilderController::class, 'update'])->name('invitations.builder.update');
    Route::post('/invitations/builder/{id}/event/add', [InvitationBuilderController::class, 'addEvent'])->name('invitations.builder.event.add');
    Route::post('/invitations/builder/{id}/event/{eventId}/update', [InvitationBuilderController::class, 'updateEvent'])->name('invitations.builder.event.update');
    Route::post('/invitations/builder/{id}/event/{eventId}/delete', [InvitationBuilderController::class, 'deleteEvent'])->name('invitations.builder.event.delete');
    Route::post('/invitations/builder/{id}/section/{sectionId}/update', [InvitationBuilderController::class, 'updateSection'])->name('invitations.builder.section.update');
    Route::post('/invitations/builder/{id}/rsvp/update', [InvitationBuilderController::class, 'updateRsvp'])->name('invitations.builder.rsvp.update');

    // Checkout & Publishing
    Route::get('/invitations/checkout/{id}', [InvitationCheckoutController::class, 'checkout'])->name('invitations.checkout.index');
    Route::post('/invitations/checkout/{id}/order/create', [InvitationCheckoutController::class, 'createOrder'])->name('invitations.checkout.order.create');
    Route::post('/invitations/checkout/{id}/payment/verify', [InvitationCheckoutController::class, 'verifyPayment'])->name('invitations.checkout.payment.verify');
    Route::post('/invitations/checkout/{id}/payment/failed', [InvitationCheckoutController::class, 'recordPaymentFailure'])->name('invitations.checkout.payment.failed');

    // Customer Member Management Dashboard
    Route::get('/dashboard/invitations', [InvitationDashboardController::class, 'index'])->name('invitations.dashboard.index');
    Route::get('/dashboard/invitations/{id}/guests', [InvitationDashboardController::class, 'guests'])->name('invitations.dashboard.guests');
    Route::post('/dashboard/invitations/{id}/guests/add', [InvitationDashboardController::class, 'addGuest'])->name('invitations.dashboard.guest.add');
    Route::post('/dashboard/invitations/{id}/guests/import', [InvitationDashboardController::class, 'importGuests'])->name('invitations.dashboard.guests.import');
    Route::post('/dashboard/invitations/{id}/guests/{guestId}/delete', [InvitationDashboardController::class, 'deleteGuest'])->name('invitations.dashboard.guest.delete');
    Route::get('/dashboard/invitations/{id}/analytics', [InvitationDashboardController::class, 'analytics'])->name('invitations.dashboard.analytics');
    Route::get('/dashboard/invitations/{id}/qr', [InvitationDashboardController::class, 'qrStudio'])->name('invitations.dashboard.qr');
    Route::get('/dashboard/invitations/{id}/memories', [InvitationDashboardController::class, 'memories'])->name('invitations.dashboard.memories');
    Route::post('/dashboard/invitations/{id}/memories/{assetId}/delete', [InvitationDashboardController::class, 'deleteMemory'])->name('invitations.dashboard.memories.delete');
    Route::post('/dashboard/invitations/{id}/whatsapp/generate', [InvitationDashboardController::class, 'generateWhatsAppMessage'])->name('invitations.dashboard.whatsapp.generate');
    Route::get('/dashboard/invitations/{id}/scanner', [InvitationDashboardController::class, 'checkInScanner'])->name('invitations.dashboard.scanner');
    Route::post('/dashboard/invitations/{id}/scanner/checkin', [InvitationDashboardController::class, 'checkInApi'])->name('invitations.dashboard.scanner.checkin');
    Route::post('/dashboard/invitations/{id}/duplicate', [InvitationDashboardController::class, 'duplicate'])->name('invitations.dashboard.duplicate');
    Route::post('/dashboard/invitations/{id}/delete', [InvitationDashboardController::class, 'delete'])->name('invitations.dashboard.delete');

    // Admin Master Control for Digital Invitations
    Route::prefix('admin/invitations')->group(function () {
        Route::get('/', [InvitationAdminController::class, 'dashboard'])->name('admin.invitations.dashboard');
        Route::get('/dashboard', [InvitationAdminController::class, 'dashboard']);
        Route::get('/categories', [InvitationAdminController::class, 'categories'])->name('admin.invitations.categories');
        Route::post('/categories/store', [InvitationAdminController::class, 'storeCategory'])->name('admin.invitations.categories.store');
        Route::get('/templates', [InvitationAdminController::class, 'templates'])->name('admin.invitations.templates');
        Route::post('/templates/store', [InvitationAdminController::class, 'storeTemplate'])->name('admin.invitations.templates.store');
        Route::get('/features', [InvitationAdminController::class, 'features'])->name('admin.invitations.features');
        Route::get('/orders', [InvitationAdminController::class, 'orders'])->name('admin.invitations.orders');
        Route::get('/submissions', [InvitationAdminController::class, 'rsvpSubmissions'])->name('admin.invitations.submissions');
        Route::get('/coupons', [InvitationAdminController::class, 'coupons'])->name('admin.invitations.coupons');
    });
});

// 4. Invitation Platform REST APIs
Route::prefix('api/invitations')->group(function () {
    Route::post('/pricing/calculate', [InvitationApiController::class, 'calculatePricing'])->name('api.invitations.pricing');
    Route::post('/coupon/validate', [InvitationApiController::class, 'validateCoupon'])->name('api.invitations.coupon');
    Route::post('/ai/love-story', [InvitationApiController::class, 'generateLoveStory'])->name('api.invitations.ai.story');
    Route::post('/ai/poetic-wording', [InvitationApiController::class, 'generatePoeticWording'])->name('api.invitations.ai.wording');
    Route::post('/ai/palette', [InvitationApiController::class, 'recommendPalette'])->name('api.invitations.ai.palette');
    Route::post('/ai/parse-prompt', [InvitationApiController::class, 'parseAiPrompt'])->name('api.invitations.ai.parse');
    Route::post('/ai/tone-copy', [InvitationApiController::class, 'generateToneCopy'])->name('api.invitations.ai.tone');
    Route::post('/ai/create-from-prompt', [InvitationApiController::class, 'createFromAiPrompt'])->name('api.invitations.ai.create');
});

