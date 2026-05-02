<?php

use App\Http\Controllers\Admin\AboutForCompanyController;
use App\Http\Controllers\Admin\AdminauthController;
use App\Http\Controllers\Admin\AdminChatController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminIncompleteOrderController;
use App\Http\Controllers\Admin\AdminproductReviewController;
use App\Http\Controllers\Admin\AdminsellerregisterapprovedController;
use App\Http\Controllers\Admin\AdminUserController as AdminAdminUserController;
use App\Http\Controllers\Admin\AffiliateproductController;
use App\Http\Controllers\Admin\AipromptController;
use App\Http\Controllers\Admin\AllorderController;
use App\Http\Controllers\Admin\AlltaxesController;
use App\Http\Controllers\Admin\CampaigncreateController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ChildSubCategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ContactinfomationadminController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DeliveryInformationController;
use App\Http\Controllers\Admin\DuplicateordersettingController;
use App\Http\Controllers\Admin\EmpleeController;
use App\Http\Controllers\Admin\FootercategoryController;
use App\Http\Controllers\Admin\GeneralsettingController;
use App\Http\Controllers\Admin\GoogleTagmanagerController;
use App\Http\Controllers\Admin\IpblockmanageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\NagadSettingController;
use App\Http\Controllers\Admin\PaymentHistoryController;
use App\Http\Controllers\Admin\OrderAssignmentController;
use App\Http\Controllers\Admin\OrderStatusHistoryController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PathaocourierController;
use App\Http\Controllers\Admin\PathaoOrderController;
use App\Http\Controllers\Admin\PaymentgetewaymanageController;
use App\Http\Controllers\Admin\PaymentSettingController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PixelController;
use App\Http\Controllers\Admin\PosController;
use App\Http\Controllers\Admin\ProductBrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\Productsettingcontroller;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ShippingChargeController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SmsgatewaysetupController;
use App\Http\Controllers\Admin\SteadfastcourierController;
use App\Http\Controllers\Admin\SteadfastOrderController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\TremsandcondationsController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\WebsitefaviconController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\PurchaseReportController;
use App\Http\Controllers\Admin\PurchaseReturnController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\BkashController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\ChatController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\FrontendauthContorller;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\IncompleteOrderController;
use App\Http\Controllers\Frontend\Landingordercontroller;
use App\Http\Controllers\Frontend\OrderTrackController;
use App\Http\Controllers\Frontend\ProductReviewController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\Shurjopaycontroller;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Manager\ManagerController;
use App\Http\Controllers\Saller\SellerauthController;
use App\Http\Controllers\Subadmin\SubadminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

// ══════════════════════════════════════════════════════════════════════════════
// FRONTEND — PUBLIC PAGES
// ══════════════════════════════════════════════════════════════════════════════
Route::get('/',                             [FrontendController::class, 'frontend']         )->name('frontend');
Route::get('/product/{slug}',               [FrontendController::class, 'productdetails']   )->name('product.detail');
Route::get('/about-company',                [FrontendController::class, 'aboutcompany']     )->name('about.company');
Route::get('/terms-and-conditions',         [FrontendController::class, 'termsAndConditions'])->name('terms.conditions');
Route::get('/contactdetails',               [FrontendController::class, 'contactDetails']   )->name('contact.details');
Route::get('/campaign/manage/{id}',         [FrontendController::class, 'campaignManage']   )->name('campaign.manage');
Route::get('/orderhistory',                 [FrontendController::class, 'orderHistory']     )->name('order.history');
Route::post('/landing/order/store',         [Landingordercontroller::class, 'store']        )->name('order.store');
Route::get('/dashboard',                    [FrontendController::class, 'user_dashboard']   )->name('user.dashboard');
Route::post('/order/cancel/{orderNumber}',  [FrontendController::class, 'cancelOrder']      )->name('order.cancel');
Route::get('/category/{slug}',              [FrontendController::class, 'categoryPage']     )->name('category.page');
Route::get('/category/{catSlug}/{subSlug}', [FrontendController::class, 'subCategoryPage']  )->name('subcategory.page');
Route::get('/category/{catSlug}/{subSlug}/{childSlug}', [FrontendController::class, 'childCategoryPage'])->name('childcategory.page');
Route::get('/shipping/areas',               [ShippingChargeController::class, 'activeAreas'])->name('shipping.areas');
Route::get('/all-products',                 [FrontendController::class, 'allProducts']      )->name('products.all');
Route::get('/shop',                         [FrontendController::class, 'shop']             )->name('shop');
Route::get('/offers',                       [FrontendController::class, 'offers']           )->name('offers');
Route::get('/new-arrivals',                 [FrontendController::class, 'newArrivals']      )->name('new-arrivals');

// ── Blog ──────────────────────────────────────────────────────────────────
Route::get('/blog',                [App\Http\Controllers\Frontend\BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}',         [App\Http\Controllers\Frontend\BlogController::class, 'show'] )->name('blog.show');

Route::get('/page/{id}',                    [FrontendController::class, 'multiplepage']     )->name('multi.plepage');
Route::post('/review/store',                [ProductReviewController::class, 'store']       )->name('review.store');

// ── Order Track ───────────────────────────────────────────────────────────────
Route::get ('/track-order', [OrderTrackController::class, 'index'])->name('order.track');
Route::post('/track-order', [OrderTrackController::class, 'track'])->name('order.track.search');

// ── Search ────────────────────────────────────────────────────────────────────
Route::get('/search/ajax', [SearchController::class, 'ajax']   )->name('search.ajax');
Route::get('/search',      [SearchController::class, 'results'])->name('search.results');

// ══════════════════════════════════════════════════════════════════════════════
// CART
// ══════════════════════════════════════════════════════════════════════════════
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get ('/',               [CartController::class, 'index']   )->name('index');
    Route::post('/add/{id}',       [CartController::class, 'add']     )->name('add');
    Route::post('/remove/{key}',   [CartController::class, 'remove']  )->name('remove');
    Route::post('/increase/{key}', [CartController::class, 'increase'])->name('increase');
    Route::post('/decrease/{key}', [CartController::class, 'decrease'])->name('decrease');
    Route::post('/clear',          [CartController::class, 'clear']   )->name('clear');
    Route::post('/coupon',         [CartController::class, 'coupon']  )->name('coupon');
    Route::get ('/count',          [CartController::class, 'count']   )->name('count');
});

// ══════════════════════════════════════════════════════════════════════════════
// WISHLIST
// ══════════════════════════════════════════════════════════════════════════════
Route::prefix('wishlist')->group(function () {
    Route::get('/',                      [WishlistController::class, 'index']     )->name('wishlist');
    Route::get('/add/{id}',              [WishlistController::class, 'add']       )->name('wishlist.add');
    Route::get('/remove/{id}',           [WishlistController::class, 'remove']    )->name('wishlist.remove');
    Route::get('/clear',                 [WishlistController::class, 'clear']     )->name('wishlist.clear');
    Route::get('/move-to-cart/{itemId}', [WishlistController::class, 'moveToCart'])->name('wishlist.moveToCart');
});

// ══════════════════════════════════════════════════════════════════════════════
// CHECKOUT
// ══════════════════════════════════════════════════════════════════════════════
Route::prefix('checkout')->group(function () {
    Route::get ('/',                      [CheckoutController::class, 'index']  )->name('checkout');
    Route::post('/place',                 [CheckoutController::class, 'place']  )->name('checkout.place');
    Route::get ('/success/{orderNumber}', [CheckoutController::class, 'success'])->name('order.success');
});

// ══════════════════════════════════════════════════════════════════════════════
// FRONTEND CHAT (public — no auth)
// ══════════════════════════════════════════════════════════════════════════════
Route::prefix('chat')->name('chat.')->group(function () {
    Route::post('start',   [ChatController::class, 'start']      )->name('start');
    Route::post('send',    [ChatController::class, 'send']       )->name('send');
    Route::get ('messages',[ChatController::class, 'getMessages'])->name('messages');
    Route::post('close',   [ChatController::class, 'close']      )->name('close');
});

// ══════════════════════════════════════════════════════════════════════════════
// PAYMENT GATEWAYS — FRONTEND
// ══════════════════════════════════════════════════════════════════════════════

// ── bKash ─────────────────────────────────────────────────────────────────────
Route::get ('/payment/bkash',          fn () => view('frontend.bkash_pay')     )->name('bkash.initiate');
Route::post('/payment/bkash/create',   [BkashController::class, 'createPayment'])->name('bkash.create');
Route::get ('/payment/bkash/callback', [BkashController::class, 'callback']    )->name('bkash.callback');

// ── ShurjoPay ─────────────────────────────────────────────────────────────────
Route::get ('/payment/shurjopay',          [Shurjopaycontroller::class, 'initiatePayment'])->name('shurjopay.initiate');
Route::get ('/payment/shurjopay/callback', [Shurjopaycontroller::class, 'callback']       )->name('shurjopay.callback');
Route::post('/payment/shurjopay/callback', [Shurjopaycontroller::class, 'callback']       );

// ══════════════════════════════════════════════════════════════════════════════
// INCOMPLETE ORDERS — FRONTEND (public AJAX)
// ══════════════════════════════════════════════════════════════════════════════
Route::prefix('incomplete-order')->name('incomplete.')->group(function () {
    Route::post('save',   [IncompleteOrderController::class, 'save']  )->name('save');
    Route::post('update', [IncompleteOrderController::class, 'update'])->name('update');
});

// ══════════════════════════════════════════════════════════════════════════════
// GENERAL AUTH
// ══════════════════════════════════════════════════════════════════════════════
Route::get ('/login',    [AuthController::class, 'showLogin']   )->name('login');
Route::post('/login',    [AuthController::class, 'login']       )->name('login.post');
Route::get ('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']    )->name('register.post');
Route::post('/logout',   [AuthController::class, 'logout']      )->name('logout');

// ══════════════════════════════════════════════════════════════════════════════
// CUSTOMER AUTH & DASHBOARD
// ══════════════════════════════════════════════════════════════════════════════
Route::get ('customer/login',        [FrontendauthContorller::class, 'customer_login']          )->name('customer.login');
Route::post('customer/login/submit', [FrontendauthContorller::class, 'customer_login_submit']   )->name('customer.login.submit');
Route::get ('customer/register',     [FrontendauthContorller::class, 'customer_register']       )->name('customer.register');
Route::post('customer/register',     [FrontendauthContorller::class, 'customer_register_submit'])->name('customer.register.submit');
Route::post('customer/logout',       [FrontendauthContorller::class, 'customer_logout']         )->name('customer.logout');

Route::middleware(['customer'])->group(function () {
    Route::get('customer/dashboard', [FrontendController::class, 'user_dashboard'])->name('customer.dashboard');
    Route::post('customer/profile/update', [App\Http\Controllers\ProfileController::class, 'updateProfile'])->name('customer.profile.update');
    Route::post('customer/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('customer.profile.password');
});

// ══════════════════════════════════════════════════════════════════════════════
// ADMIN AUTH (public — outside admin middleware)
// ══════════════════════════════════════════════════════════════════════════════
Route::get ('/admin/login',  [AdminauthController::class, 'admin_login']       )->name('admin.login');
Route::post('/admin/login',  [AdminauthController::class, 'admin_login_submit'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminauthController::class, 'admin_logout']      )->name('admin.logout');

// ══════════════════════════════════════════════════════════════════════════════
// STEADFAST WEBHOOK (public — outside admin auth)
// ══════════════════════════════════════════════════════════════════════════════
Route::post('webhook/steadfast', [SteadfastOrderController::class, 'webhook'])->name('steadfast.webhook');

// ══════════════════════════════════════════════════════════════════════════════
// CUSTOMER RESOURCE — ADMIN middleware, NO admin. prefix
// (পুরানো code compatibility রক্ষায় prefix ছাড়া রাখা হয়েছে)
// ══════════════════════════════════════════════════════════════════════════════
Route::middleware(['admin'])->group(function () {
    Route::resource('customer', CustomerController::class);
    Route::post('customer/{id}/status',      [CustomerController::class, 'updateStatus'])->name('customer.status');
    Route::post('customer/{id}/make-vendor', [CustomerController::class, 'makeVendor']  )->name('customer.makeVendor');
});

// ══════════════════════════════════════════════════════════════════════════════
// ADMIN — ALL PROTECTED ROUTES
// URL prefix  : /admin/
// Route prefix: admin.
// ══════════════════════════════════════════════════════════════════════════════
Route::middleware(['admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    // ── Dashboard ─────────────────────────────────────────────────────────────
    Route::get('dashboard', [AdminController::class, 'admin_dashboard'])->name('dashboard');

    // Profile Routes — inside admin. name group, so just 'profile.*' needed
    Route::get ('profile',          [App\Http\Controllers\ProfileController::class, 'index']         )->name('profile.index');
    Route::post('profile/update',   [App\Http\Controllers\ProfileController::class, 'updateProfile'] )->name('profile.update');
    Route::post('profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');

    // ──────────────────────────────────────────────────────────────────────────
    // POS
    // prefix: admin/pos  |  name: admin.pos.*
    // ──────────────────────────────────────────────────────────────────────────
    Route::prefix('pos')->name('pos.')->group(function () {
        Route::get ('/',                        [PosController::class, 'index']         )->name('index');
        Route::get ('/search-products',         [PosController::class, 'searchProducts'])->name('searchProducts');
        Route::get ('/search-customers',        [PosController::class, 'searchCustomers'])->name('searchCustomers');
        Route::post('/store-customer',          [PosController::class, 'storeCustomer'] )->name('storeCustomer');
        Route::post('/apply-coupon',            [PosController::class, 'applyCoupon']   )->name('applyCoupon');
        Route::post('/place-order',             [PosController::class, 'placeOrder']    )->name('placeOrder');
        Route::post('/cancel-order/{session}',  [PosController::class, 'cancelOrder']   )->name('cancelOrder');
        Route::get ('/invoice/{session}',       [PosController::class, 'invoice']       )->name('invoice');
        Route::get ('/orders',                  [PosController::class, 'orders']        )->name('orders');
    });

    // ──────────────────────────────────────────────────────────────────────────
    // SELLER REGISTRATION
    // ──────────────────────────────────────────────────────────────────────────
    // ⚠️ Static routes BEFORE parameterised routes
    Route::get('sellerregistercheck',                   [AdminsellerregisterapprovedController::class, 'seller_register_check']     )->name('seller.register.check');
    Route::get('seller/register/status',                [AdminsellerregisterapprovedController::class, 'seller_register_status']    )->name('seller.register.status');
    Route::get('seller-registrations',                  [AdminsellerregisterapprovedController::class, 'seller_register_check']     )->name('seller.register.list');
    Route::get('seller-registrations/export',           [AdminsellerregisterapprovedController::class, 'seller_register_export']    )->name('seller.register.export');
    Route::get('seller-registrations/{id}/view',        [AdminsellerregisterapprovedController::class, 'seller_register_view']      )->name('seller.register.view');
    Route::put('seller-registrations/{id}/approve',     [AdminsellerregisterapprovedController::class, 'seller_register_approve']   )->name('seller.register.approve');
    Route::put('seller-registrations/{id}/reject',      [AdminsellerregisterapprovedController::class, 'seller_register_reject']    )->name('seller.register.reject');
    Route::put('seller-registrations/{id}/suspend',     [AdminsellerregisterapprovedController::class, 'seller_register_suspend']   )->name('seller.register.suspend');
    Route::put('seller-registrations/{id}/reactivate',  [AdminsellerregisterapprovedController::class, 'seller_register_reactivate'])->name('seller.register.reactivate');

    // ──────────────────────────────────────────────────────────────────────────
    // COUPONS
    // ──────────────────────────────────────────────────────────────────────────
    Route::post('coupons/{id}/status', [CouponController::class, 'updateStatus'])->name('coupons.status');
    Route::resource('coupons', CouponController::class);

    // ──────────────────────────────────────────────────────────────────────────
    // ROLES & PERMISSIONS
    // name: admin.roles.*  |  admin.permissions.*
    // ⚠️ Custom routes BEFORE resource — noinlè {role} wildcard match korbe
    // ──────────────────────────────────────────────────────────────────────────
    Route::get ('roles/{role}/assign-permission',        [RoleController::class, 'assignPermission']      )->name('roles.assignPermission');
    Route::put ('roles/{role}/save-assigned-permission', [RoleController::class, 'saveAssignedPermission'])->name('roles.saveAssignedPermission');
    Route::resource('roles', RoleController::class);

    Route::post('permissions/bulk-create', [PermissionController::class, 'bulkCreate'])->name('permissions.bulkCreate');
    Route::resource('permissions', PermissionController::class);

    // ──────────────────────────────────────────────────────────────────────────
    // USERS
    // name: admin.users.*
    // AdminUserController aliased to avoid collision with root UserController
    // ──────────────────────────────────────────────────────────────────────────
    Route::patch('users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::resource('users', AdminUserController::class);

    // ──────────────────────────────────────────────────────────────────────────
    // CATEGORIES
    // ──────────────────────────────────────────────────────────────────────────
    Route::get('category/{id}/toggle-featured', [CategoryController::class, 'toggleFeatured'])->name('category.toggle-featured');
    Route::get('category/{id}/toggle-status',   [CategoryController::class, 'toggleStatus']  )->name('category.toggle-status');
    Route::resource('category', CategoryController::class);

    // ── Sub-Categories ────────────────────────────────────────────────────────
    Route::get('subcategory/{id}/toggle-featured', [SubCategoryController::class, 'toggleFeatured'])->name('subcategory.toggle-featured');
    Route::get('subcategory/{id}/toggle-status',   [SubCategoryController::class, 'toggleStatus']  )->name('subcategory.toggle-status');
    Route::resource('subcategory', SubCategoryController::class);

    // ── Child Categories ──────────────────────────────────────────────────────
    Route::get('childcategory/{id}/toggle-featured', [ChildSubCategoryController::class, 'childtoggleFeatured'])->name('childcategory.toggle-featured');
    Route::get('childcategory/{id}/toggle-status',   [ChildSubCategoryController::class, 'childtoggleStatus']  )->name('childcategory.toggle-status');
    Route::get('get-subcategories',                  [ChildSubCategoryController::class, 'getSubCategories']   )->name('childcategory.getSubCategories');
    Route::resource('childcategory', ChildSubCategoryController::class);

    // ──────────────────────────────────────────────────────────────────────────
    // PRODUCTS
    // ⚠️ Static routes BEFORE Route::resource() — noinlè /products/{id} match korbe
    // ──────────────────────────────────────────────────────────────────────────
    Route::get ('products/get-subcategories',       [ProductController::class, 'getSubCategories']  )->name('products.getSubCategories');
    Route::get ('products/get-childcategories',     [ProductController::class, 'getChildCategories'])->name('products.getChildCategories');
    Route::get ('products/deactivated',             [ProductController::class, 'deactivated']       )->name('products.deactivated');
    Route::get ('products/flash-sales',             [ProductController::class, 'flashSalesIndex']   )->name('products.flash-sales');
    Route::get ('products/new-arrivals',            [ProductController::class, 'newArrivalsIndex']  )->name('products.new-arrivals');
    Route::get ('products/bestsellers',             [ProductController::class, 'bestsellersIndex']  )->name('products.bestsellers');
    Route::get ('products/catalog',                 [ProductController::class, 'catalogIndex']      )->name('products.catalog');
    Route::get ('products/{id}/toggle-status',      [ProductController::class, 'toggleStatus']      )->name('products.toggle-status');
    Route::get ('products/{id}/catalog-add',        [ProductController::class, 'catalogAdd']        )->name('products.catalog.add');
    Route::get ('products/{id}/catalog-gallery',    [ProductController::class, 'catalogGallery']    )->name('products.catalog.gallery');
    Route::post('products/{id}/catalog-remove',     [ProductController::class, 'catalogRemove']     )->name('products.catalog.remove');
    Route::post('products/{id}/catalog-highlight',  [ProductController::class, 'catalogHighlight']  )->name('products.catalog.highlight');
    Route::post('products/{id}/toggle-flash-sale',  [ProductController::class, 'toggleFlashSale']   )->name('products.toggle-flash-sale');
    Route::post('products/{id}/update-flash-sale',  [ProductController::class, 'updateFlashSale']   )->name('products.update-flash-sale');
    Route::post('products/{id}/toggle-new-arrival', [ProductController::class, 'toggleNewArrival']  )->name('products.toggle-new-arrival');
    Route::post('products/{id}/toggle-bestseller',  [ProductController::class, 'toggleBestseller']  )->name('products.toggle-bestseller');
    Route::resource('products', ProductController::class);

    // ──────────────────────────────────────────────────────────────────────────
    // PRODUCT SETTINGS
    // ──────────────────────────────────────────────────────────────────────────
    Route::get ('product-settings',        [Productsettingcontroller::class, 'index'] )->name('product.settings.index');
    Route::put ('product-settings/update', [Productsettingcontroller::class, 'update'])->name('product.settings.update');

    // ──────────────────────────────────────────────────────────────────────────
    // AFFILIATE PRODUCTS
    // ──────────────────────────────────────────────────────────────────────────
    Route::get ('affiliateproduct/get-sub-categories',   [AffiliateproductController::class, 'getSubCategories']  )->name('affiliateproduct.sub-categories');
    Route::get ('affiliateproduct/get-child-categories', [AffiliateproductController::class, 'getChildCategories'])->name('affiliateproduct.child-categories');
    Route::post('affiliateproduct/{id}/toggle-status',   [AffiliateproductController::class, 'toggleStatus']      )->name('affiliateproduct.toggle-status');
    Route::resource('affiliateproduct', AffiliateproductController::class);

    // ──────────────────────────────────────────────────────────────────────────
    // GENERAL SETTINGS
    // ──────────────────────────────────────────────────────────────────────────
    Route::post('Generalsettings/upload-logo', [GeneralsettingController::class, 'uploadLogo'])->name('Generalsettings.upload-logo');
    Route::post('Generalsettings/delete-logo', [GeneralsettingController::class, 'deleteLogo'])->name('Generalsettings.delete-logo');
    Route::resource('Generalsettings', GeneralsettingController::class);

    // ──────────────────────────────────────────────────────────────────────────
    // WEBSITE FAVICON
    // ──────────────────────────────────────────────────────────────────────────
    Route::post('websitefavicon/upload-logo', [WebsitefaviconController::class, 'uploadLogo'])->name('websitefavicon.upload-logo');
    Route::post('websitefavicon/delete-logo', [WebsitefaviconController::class, 'deleteLogo'])->name('websitefavicon.delete-logo');
    Route::resource('websitefavicon', WebsitefaviconController::class);

    // ── Footer Settings ──────────────────────────────────────────────────────
    Route::get ('footer-settings',        [App\Http\Controllers\Admin\FooterSettingController::class, 'index'] )->name('footer-settings.index');
    Route::put ('footer-settings/update', [App\Http\Controllers\Admin\FooterSettingController::class, 'update'])->name('footer-settings.update');


    // ──────────────────────────────────────────────────────────────────────────
    // SLIDER
    // ──────────────────────────────────────────────────────────────────────────
    Route::resource('slider', SliderController::class);

    // ──────────────────────────────────────────────────────────────────────────
    Route::prefix('shipping')->name('shipping.')->group(function () {
        Route::get('{shipping}/toggle-status', [ShippingChargeController::class, 'toggleStatus'])->name('toggle-status');
    });
    Route::resource('shipping', ShippingChargeController::class)->except(['show']);

    // ──────────────────────────────────────────────────────────────────────────
    // ORDERS
    // ⚠️ Bulk/static routes BEFORE parameterised routes
    // ──────────────────────────────────────────────────────────────────────────
    Route::delete('orders/bulk-delete',          [AllorderController::class,     'bulkDelete']         )->name('order.bulk-delete');
    Route::patch ('orders/bulk-status',          [AllorderController::class,     'bulkStatus']          )->name('order.bulk-status');
    Route::post  ('orders/bulk-send-steadfast',  [SteadfastOrderController::class, 'bulkSend']         )->name('steadfast.bulk-send');
    Route::post  ('orders/bulk-send-pathao',     [PathaoOrderController::class,  'bulkSend']            )->name('pathao.bulk-send');
    Route::get   ('orders/create',               [OrderController::class,        'create']              )->name('order.create');
    Route::post  ('orders',                      [OrderController::class,        'store']               )->name('order.store');
    Route::get   ('orders',                      [AllorderController::class,     'allorder']            )->name('order.allorder');
    // Parameterised routes
    Route::get   ('orders/{id}',                 [AllorderController::class,     'show']                )->name('order.show');
    Route::get   ('orders/{id}/edit',            [OrderController::class,        'edit']                )->name('order.edit');
    Route::put   ('orders/{id}',                 [OrderController::class,        'update']              )->name('order.update');
    Route::patch ('orders/{id}/status',          [AllorderController::class,     'updateStatus']        )->name('order.status');
    Route::patch ('orders/{id}/payment-status',  [AllorderController::class,     'updatePaymentStatus'] )->name('order.payment-status');
    Route::get ('orders/{id}/assign-staff', [AllorderController::class, 'assignStaffPage'])->name('order.assign-staff');
    Route::patch('orders/{id}/assign-staff/update', [AllorderController::class, 'assignStaff'])->name('order.assign-staff.update');

    // Order Assignments Dashboard
    Route::get ('order-assignments',             [OrderAssignmentController::class, 'index']      )->name('order.assignments.index');
    Route::get ('order-assignments/staff/{id}',  [OrderAssignmentController::class, 'staffOrders'])->name('order.assignments.staff');
    Route::post('order-assignments/bulk',        [OrderAssignmentController::class, 'bulkAssign'] )->name('order.assignments.bulk');

    // Order Activity History
    Route::get ('order-history',                 [OrderStatusHistoryController::class, 'index']        )->name('order-history.index');
    Route::get ('order-history/staff/{id}',      [OrderStatusHistoryController::class, 'staffActivity'])->name('order-history.staff');

    Route::delete('orders/{id}',                 [AllorderController::class,     'destroy']             )->name('order.destroy');
    Route::post  ('orders/{order}/send-steadfast',[SteadfastOrderController::class, 'send']             )->name('steadfast.send');
    Route::post  ('orders/{order}/send-pathao',  [PathaoOrderController::class,  'send']                )->name('pathao.send');

    // ── Steadfast misc ────────────────────────────────────────────────────────
    Route::get('steadfast/test', [SteadfastOrderController::class, 'test'])->name('steadfast.test');
    Route::resource('steadfastcourier', SteadfastcourierController::class);

    // ── Pathao misc ───────────────────────────────────────────────────────────
    Route::get('pathao/test',          [PathaoOrderController::class, 'test']        )->name('pathao.test');
    Route::get('pathao/stores',        [PathaoOrderController::class, 'getStores']   )->name('pathao.stores');
    Route::get('pathao/cities',        [PathaoOrderController::class, 'getCities']   )->name('pathao.cities');
    Route::get('pathao/zones',         [PathaoOrderController::class, 'getZones']    )->name('pathao.zones');
    Route::get('pathao/areas',         [PathaoOrderController::class, 'getAreas']    )->name('pathao.areas');
    Route::get('pathao/debug/phone',   [PathaoOrderController::class, 'debugPhone']  )->name('pathao.debug.phone');
    Route::get('pathao/debug/payload', [PathaoOrderController::class, 'debugPayload'])->name('pathao.debug.payload');
    Route::get('pathao/debug/token',   [PathaoOrderController::class, 'debugToken']  )->name('pathao.debug.token');
    Route::get('pathaocourier/generate-token', [PathaocourierController::class, 'generateToken'])->name('pathaocourier.generate-token');
    Route::resource('pathaocourier', PathaocourierController::class);

    // ──────────────────────────────────────────────────────────────────────────
    // INCOMPLETE ORDERS — ADMIN PANEL
    // prefix: admin/incomplete-orders  |  name: admin.incomplete-orders.*
    // ──────────────────────────────────────────────────────────────────────────
    Route::prefix('incomplete-orders')->name('incomplete-orders.')->group(function () {
        Route::get('/', [AdminIncompleteOrderController::class, 'index'])->name('index');
        Route::get('/', [AdminIncompleteOrderController::class, 'index'])->name('index');

        // Bulk (static — BEFORE parameterised)
        Route::delete('bulk-delete',           [AdminIncompleteOrderController::class, 'bulkDelete']      )->name('bulk-delete');
        Route::patch ('bulk-status',           [AdminIncompleteOrderController::class, 'bulkStatus']      )->name('bulk-status');
        Route::post  ('steadfast/bulk-send',   [AdminIncompleteOrderController::class, 'steadfastBulkSend'])->name('steadfast.bulk-send');
        Route::post  ('pathao/bulk-send',      [AdminIncompleteOrderController::class, 'pathaoBulkSend']  )->name('pathao.bulk-send');

        // Single record (parameterised — AFTER static)
        Route::get   ('{incompleteOrder}',              [AdminIncompleteOrderController::class, 'show']         )->name('show');
        Route::delete('{incompleteOrder}',              [AdminIncompleteOrderController::class, 'destroy']      )->name('destroy');
        Route::patch ('{incompleteOrder}/status',       [AdminIncompleteOrderController::class, 'updateStatus'] )->name('update-status');
        Route::patch ('{incompleteOrder}/contacted',    [AdminIncompleteOrderController::class, 'markContacted'])->name('contacted');
        Route::patch ('{incompleteOrder}/recovered',    [AdminIncompleteOrderController::class, 'markRecovered'])->name('recovered');
        Route::post  ('{incompleteOrder}/steadfast-send',[AdminIncompleteOrderController::class, 'steadfastSend'])->name('steadfast.send');
        Route::post  ('{incompleteOrder}/pathao-send',  [AdminIncompleteOrderController::class, 'pathaoSend']   )->name('pathao.send');
    });

    // ──────────────────────────────────────────────────────────────────────────
    // ADMIN CHAT PANEL
    // prefix: admin/chat  |  name: admin.chat.*
    // ──────────────────────────────────────────────────────────────────────────
    Route::prefix('chat')->name('chat.')->group(function () {
        Route::get ('/',                       [AdminChatController::class, 'index']      )->name('index');
        Route::get ('/unread-count',           [AdminChatController::class, 'unreadCount'])->name('unread');
        Route::get ('/{chatSession}',          [AdminChatController::class, 'show']       )->name('show');
        Route::post('/{chatSession}/reply',    [AdminChatController::class, 'reply']      )->name('reply');
        Route::get ('/{chatSession}/messages', [AdminChatController::class, 'getMessages'])->name('messages');
        Route::post('/{chatSession}/close',    [AdminChatController::class, 'close']      )->name('close');
    });

    // ──────────────────────────────────────────────────────────────────────────
    // PRODUCT REVIEWS
    // name: admin.reviews.*
    // ⚠️ Bulk route BEFORE parameterised route
    // ──────────────────────────────────────────────────────────────────────────
    Route::post  ('reviews/bulk',           [AdminproductReviewController::class, 'bulk']     )->name('reviews.bulk');
    Route::get   ('reviews',                [AdminproductReviewController::class, 'index']    )->name('reviews.index');
    Route::post  ('reviews/{id}/approve',   [AdminproductReviewController::class, 'approve']  )->name('reviews.approve');
    Route::post  ('reviews/{id}/unapprove', [AdminproductReviewController::class, 'unapprove'])->name('reviews.unapprove');
    Route::delete('reviews/{id}',           [AdminproductReviewController::class, 'destroy']  )->name('reviews.destroy');

    // ──────────────────────────────────────────────────────────────────────────
    // PAYMENT SETTINGS
    // name: admin.payment.*
    // ──────────────────────────────────────────────────────────────────────────
    Route::get ('payment-settings',                  [PaymentSettingController::class, 'index']          )->name('payment.index');
    Route::post('payment-settings/bkash',            [PaymentSettingController::class, 'bkashStore']     )->name('payment.bkash.store');
    Route::post('payment-settings/shurjopay',        [PaymentSettingController::class, 'shurjopayStore'] )->name('payment.shurjopay.store');
    Route::post('payment-settings/bkash/toggle',     [PaymentSettingController::class, 'bkashToggle']    )->name('payment.bkash.toggle');
    Route::post('payment-settings/shurjopay/toggle', [PaymentSettingController::class, 'shurjopayToggle'])->name('payment.shurjopay.toggle');

    // ──────────────────────────────────────────────────────────────────────────
    // VAT & TAXES  (একবারই define করা হয়েছে)
    // ──────────────────────────────────────────────────────────────────────────
    Route::post('alltaxes/{alltaxes}/toggle', [AlltaxesController::class, 'toggleStatus'])->name('alltaxes.toggle');
    Route::resource('alltaxes', AlltaxesController::class);

    // ──────────────────────────────────────────────────────────────────────────
    // COLORS
    // ──────────────────────────────────────────────────────────────────────────
    Route::post('color/{color}/toggle', [ColorController::class, 'toggleStatus'])->name('color.toggle');
    Route::resource('color', ColorController::class);

    // ──────────────────────────────────────────────────────────────────────────
    // SIZES
    // ──────────────────────────────────────────────────────────────────────────
    Route::post('size/{size}/toggle', [SizeController::class, 'toggleStatus'])->name('size.toggle');
    Route::resource('size', SizeController::class);

    // ──────────────────────────────────────────────────────────────────────────
    // UNITS
    // ──────────────────────────────────────────────────────────────────────────
    Route::post('unit/{unit}/toggle', [UnitController::class, 'toggleStatus'])->name('unit.toggle');
    Route::resource('unit', UnitController::class);

    // ──────────────────────────────────────────────────────────────────────────
    // PRODUCT BRANDS
    // ──────────────────────────────────────────────────────────────────────────
    Route::post('productbrands/{productbrand}/toggle', [ProductBrandController::class, 'toggleStatus'])->name('productbrands.toggle');
    Route::resource('productbrands', ProductBrandController::class);

    // ──────────────────────────────────────────────────────────────────────────
    // DUPLICATE ORDER SETTING
    // ──────────────────────────────────────────────────────────────────────────
    Route::patch('duplicateordersetting/{duplicateordersetting}/toggle-status', [DuplicateordersettingController::class, 'toggleStatus'])->name('duplicateordersetting.toggleStatus');
    Route::resource('duplicateordersetting', DuplicateordersettingController::class);

    // ──────────────────────────────────────────────────────────────────────────
    // IP BLOCK MANAGE
    // ──────────────────────────────────────────────────────────────────────────
    Route::patch('Ipblockmanage/{Ipblockmanage}/toggle-status', [IpblockmanageController::class, 'toggleStatus'])->name('Ipblockmanage.toggleStatus');
    Route::resource('Ipblockmanage', IpblockmanageController::class);

    // ──────────────────────────────────────────────────────────────────────────
    // AI PROMPT
    // ──────────────────────────────────────────────────────────────────────────
    Route::post('aiprompt/update-product', [AipromptController::class, 'updateProduct'])->name('aiprompt.update-product');
    Route::post('aiprompt/update-page',    [AipromptController::class, 'updatePage']   )->name('aiprompt.update-page');
    Route::post('aiprompt/update-blog',    [AipromptController::class, 'updateBlog']   )->name('aiprompt.update-blog');
    Route::resource('aiprompt', AipromptController::class)->only(['index', 'store']);

    // ──────────────────────────────────────────────────────────────────────────
    // OTHER RESOURCES
    // ──────────────────────────────────────────────────────────────────────────
    Route::resource('contact',                ContactController::class);
    Route::resource('pixels',                 PixelController::class);
    Route::resource('googletagmanager',       GoogleTagmanagerController::class);
    Route::resource('Smsgatewaysetup',        SmsgatewaysetupController::class);
    Route::resource('campaigncreate',         CampaigncreateController::class);
    Route::resource('contactinfomationadmins',ContactinfomationadminController::class);
    Route::resource('aboutcompany',           AboutForCompanyController::class);
    Route::resource('tremsandcondation',      TremsandcondationsController::class);
    Route::resource('pages',                  PageController::class);
    Route::resource('footercategory',         FootercategoryController::class);
    Route::resource('DeliveryInformation',    DeliveryInformationController::class);

    // ── Payment Gateway Manage ────────────────────────────────────────────────
    Route::patch('paymentgetewaymanage/{id}/toggle-status', [PaymentgetewaymanageController::class, 'toggleStatus'])->name('paymentgetewaymanage.toggle-status');
    Route::resource('paymentgetewaymanage', PaymentgetewaymanageController::class);

    // Nagad API Settings
    Route::get ('nagad-setting',        [NagadSettingController::class, 'index'] )->name('nagad.index');
    Route::post('nagad-setting/update', [NagadSettingController::class, 'update'])->name('nagad.update');

    // Payment History
    Route::get('payment-history', [PaymentHistoryController::class, 'index'])->name('payment.history');

    // ── Blog ──────────────────────────────────────────────────────────────────
    Route::resource('blog-categories', App\Http\Controllers\Admin\BlogCategoryController::class);
    Route::resource('blog-posts', App\Http\Controllers\Admin\BlogPostController::class);

    Route::get ('mail-setting',        [App\Http\Controllers\Admin\MailsettingController::class, 'index'] )->name('mail.index');
    Route::post('mail-setting/update', [App\Http\Controllers\Admin\MailsettingController::class, 'update'])->name('mail.update');
    Route::post('mail-setting/test',   [App\Http\Controllers\Admin\MailsettingController::class, 'sendTestMail'])->name('mail.test');

    // ── Purchase Management ────────────────────────────────────
    // ── Suppliers ──────────────────────────────────────────────────
    Route::resource('suppliers', SupplierController::class);
    Route::post('suppliers/{id}/toggle-status', [SupplierController::class, 'toggleStatus'])->name('suppliers.toggle');

    // ── Purchases ──────────────────────────────────────────────────
    Route::get ('purchases/export',              [PurchaseController::class, 'exportExcel']     )->name('purchases.export');
    Route::get ('purchases/summary',             [PurchaseController::class, 'summary']          )->name('purchases.summary');
    Route::get ('purchases/{purchase}/pdf',       [PurchaseController::class, 'downloadPdf']     )->name('purchases.pdf');
    Route::resource('purchases', PurchaseController::class);
    Route::post  ('purchases/{purchase}/attach-items',   [PurchaseController::class, 'attachItems']  )->name('purchases.attach');
    Route::delete('purchases/items/{item}',              [PurchaseController::class, 'removeItem']   )->name('purchases.remove-item');
    Route::patch ('purchases/{purchase}/mark-received',  [PurchaseController::class, 'markAsReceived'])->name('purchases.mark-received');

    // ── Purchase Reports ───────────────────────────────────────────
    Route::get('purchase-report',        [PurchaseReportController::class, 'stockReport']      )->name('purchases.report');
    Route::get('purchase-stock-export',  [PurchaseReportController::class, 'exportStockExcel'] )->name('purchases.stock-export');

    // ── Purchase Returns ───────────────────────────────────────────
    Route::resource('purchase-returns', PurchaseReturnController::class);
    Route::patch('purchase-returns/{purchaseReturn}/approve', [PurchaseReturnController::class, 'approve'])->name('purchase-returns.approve');
    Route::patch('purchase-returns/{purchaseReturn}/reject',  [PurchaseReturnController::class, 'reject'] )->name('purchase-returns.reject');

}); // end admin group

// ══════════════════════════════════════════════════════════════════════════════
// SELLER
// ══════════════════════════════════════════════════════════════════════════════
Route::get ('seller/login',    [SellerauthController::class, 'saller_login']          )->name('saller.login');
Route::get ('seller/register', [SellerauthController::class, 'saller_register']       )->name('saller.register');
Route::post('seller/login',    [SellerauthController::class, 'saller_login_submit']   )->name('saller.login.submit');
Route::post('seller',          [SellerauthController::class, 'saller_register_submit'])->name('saller.register.submit');

Route::middleware(['saller'])->group(function () {
    Route::get ('saller/dashboard', [SellerauthController::class, 'saller_dashboard'])->name('saller.dashboard');
    Route::post('saller/logout',    [SellerauthController::class, 'saller_logout']   )->name('saller.logout');
    Route::post('saller/profile/update', [App\Http\Controllers\ProfileController::class, 'updateProfile'])->name('saller.profile.update');
    Route::post('saller/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('saller.profile.password');
});

// ══════════════════════════════════════════════════════════════════════════════
// EMPLOYEE
// ══════════════════════════════════════════════════════════════════════════════
Route::get ('emplee/login',        [EmpleeController::class, 'emplee']       )->name('emplee.login');
Route::post('emplee/login/submit', [EmpleeController::class, 'loginSubmit']  )->name('emplee.login.submit');
Route::post('emplee/logout',       [EmpleeController::class, 'emplee_logout'])->name('emplee.logout');

Route::middleware(['emplee'])->group(function () {
    Route::get('emplee/dashboard', [EmpleeController::class, 'emplee_dashboard'])->name('emplee.dashboard');

    // Profile Routes
    Route::get('emplee/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('emplee.profile.index');
    Route::post('emplee/profile/update', [App\Http\Controllers\ProfileController::class, 'updateProfile'])->name('emplee.profile.update');
    Route::post('emplee/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('emplee.profile.password');

    // ── Orders ────────────────────────────────────────────────────────────────
    Route::delete('emplee/orders/bulk-delete',         [App\Http\Controllers\Admin\AllorderController::class, 'bulkDelete'])->name('emplee.orders.bulk-delete');
    Route::patch ('emplee/orders/bulk-status',         [App\Http\Controllers\Admin\AllorderController::class, 'bulkStatus'])->name('emplee.orders.bulk-status');
    Route::post  ('emplee/orders/bulk-send-steadfast', [App\Http\Controllers\Admin\SteadfastOrderController::class, 'bulkSend'])->name('emplee.orders.steadfast.bulk-send');
    Route::post  ('emplee/orders/bulk-send-pathao',    [App\Http\Controllers\Admin\PathaoOrderController::class, 'bulkSend'])->name('emplee.orders.pathao.bulk-send');
    Route::get   ('emplee/orders/create',              [App\Http\Controllers\Admin\OrderController::class, 'create'])->name('emplee.orders.create');
    Route::post  ('emplee/orders',                     [App\Http\Controllers\Admin\OrderController::class, 'store'])->name('emplee.orders.store');
    Route::get   ('emplee/orders',                     [App\Http\Controllers\Admin\AdminController::class, 'all_order'])->name('emplee.orders.index');
    Route::get   ('emplee/orders/{id}',                [App\Http\Controllers\Admin\AllorderController::class, 'show'])->name('emplee.orders.show');
    Route::get   ('emplee/orders/{id}/edit',           [App\Http\Controllers\Admin\OrderController::class, 'edit'])->name('emplee.orders.edit');
    Route::put   ('emplee/orders/{id}',                [App\Http\Controllers\Admin\OrderController::class, 'update'])->name('emplee.orders.update');
    Route::patch ('emplee/orders/{id}/status',         [App\Http\Controllers\Admin\AllorderController::class, 'updateStatus'])->name('emplee.orders.status');
    Route::patch ('emplee/orders/{id}/assign-staff',   [App\Http\Controllers\Admin\AdminController::class, 'assignStaff'])->name('emplee.orders.assign-staff');
    Route::delete('emplee/orders/{id}',                [App\Http\Controllers\Admin\AllorderController::class, 'destroy'])->name('emplee.orders.destroy');
    Route::post  ('emplee/orders/{order}/send-steadfast', [App\Http\Controllers\Admin\SteadfastOrderController::class, 'send'])->name('emplee.orders.steadfast.send');
    Route::post  ('emplee/orders/{order}/send-pathao',    [App\Http\Controllers\Admin\PathaoOrderController::class, 'send'])->name('emplee.orders.pathao.send');

    // ── Categories ────────────────────────────────────────────────────────────
    Route::resource('emplee/category',    App\Http\Controllers\Admin\CategoryController::class,    ['as' => 'emplee']);
    Route::resource('emplee/subcategory', App\Http\Controllers\Admin\SubCategoryController::class, ['as' => 'emplee']);
    Route::resource('emplee/products',    App\Http\Controllers\Admin\ProductController::class,     ['as' => 'emplee']);

    // ── Coupons ───────────────────────────────────────────────────────────────
    Route::get   ('emplee/coupons',          [App\Http\Controllers\Admin\CouponController::class, 'index']  )->name('emplee.coupon.index');
    Route::get   ('emplee/coupons/create',   [App\Http\Controllers\Admin\CouponController::class, 'create'] )->name('emplee.coupon.create');
    Route::post  ('emplee/coupons',          [App\Http\Controllers\Admin\CouponController::class, 'store']  )->name('emplee.coupon.store');
    Route::get   ('emplee/coupons/{id}/edit',[App\Http\Controllers\Admin\CouponController::class, 'edit']   )->name('emplee.coupon.edit');
    Route::put   ('emplee/coupons/{id}',     [App\Http\Controllers\Admin\CouponController::class, 'update'] )->name('emplee.coupon.update');
    Route::delete('emplee/coupons/{id}',     [App\Http\Controllers\Admin\CouponController::class, 'destroy'])->name('emplee.coupon.destroy');

    // ── Chat ──────────────────────────────────────────────────────────────────
    Route::prefix('emplee/chat')->name('emplee.chat.')->group(function () {
        Route::get ('/',                       [App\Http\Controllers\Admin\AdminChatController::class, 'index']      )->name('index');
        Route::get ('/unread-count',           [App\Http\Controllers\Admin\AdminChatController::class, 'unreadCount'])->name('unread');
        Route::get ('/{chatSession}',          [App\Http\Controllers\Admin\AdminChatController::class, 'show']       )->name('show');
        Route::post('/{chatSession}/reply',    [App\Http\Controllers\Admin\AdminChatController::class, 'reply']      )->name('reply');
        Route::get ('/{chatSession}/messages', [App\Http\Controllers\Admin\AdminChatController::class, 'getMessages'])->name('messages');
        Route::post('/{chatSession}/close',    [App\Http\Controllers\Admin\AdminChatController::class, 'close']      )->name('close');
    });

    // ── Blog ──────────────────────────────────────────────────────────────────
    Route::resource('emplee/blog-categories', App\Http\Controllers\Admin\BlogCategoryController::class, ['as' => 'emplee']);
    Route::resource('emplee/blog-posts', App\Http\Controllers\Admin\BlogPostController::class, ['as' => 'emplee']);

    // ── Purchase Management ────────────────────────────────────
    Route::resource('emplee/suppliers', SupplierController::class, ['as' => 'emplee']);
    Route::resource('emplee/purchases', PurchaseController::class, ['as' => 'emplee']);
    Route::get('emplee/purchase-report', [PurchaseReportController::class, 'stockReport'])->name('emplee.purchases.report');
});

// ══════════════════════════════════════════════════════════════════════════════
// MANAGER
// ══════════════════════════════════════════════════════════════════════════════
Route::get ('manager/login',        [ManagerController::class, 'manager_login']       )->name('manager.login');
Route::post('manager/login/submit', [ManagerController::class, 'manager_login_submit'])->name('manager.login.submit');
Route::post('manager/logout',       [ManagerController::class, 'manager_logout']      )->name('manager.logout');

Route::middleware(['manager'])->group(function () {
    Route::get('manager/dashboard', [ManagerController::class, 'manager_dashboard'])->name('manager.dashboard');

    // Profile Routes
    Route::get('manager/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('manager.profile.index');
    Route::post('manager/profile/update', [App\Http\Controllers\ProfileController::class, 'updateProfile'])->name('manager.profile.update');
    Route::post('manager/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('manager.profile.password');

    // ── Orders ────────────────────────────────────────────────────────────────
    Route::delete('manager/orders/bulk-delete',         [App\Http\Controllers\Admin\AllorderController::class, 'bulkDelete'])->name('manager.orders.bulk-delete');
    Route::patch ('manager/orders/bulk-status',         [App\Http\Controllers\Admin\AllorderController::class, 'bulkStatus'])->name('manager.orders.bulk-status');
    Route::post  ('manager/orders/bulk-send-steadfast', [App\Http\Controllers\Admin\SteadfastOrderController::class, 'bulkSend'])->name('manager.orders.steadfast.bulk-send');
    Route::post  ('manager/orders/bulk-send-pathao',    [App\Http\Controllers\Admin\PathaoOrderController::class, 'bulkSend'])->name('manager.orders.pathao.bulk-send');
    Route::get   ('manager/orders/create',              [App\Http\Controllers\Admin\OrderController::class, 'create'])->name('manager.orders.create');
    Route::post  ('manager/orders',                     [App\Http\Controllers\Admin\OrderController::class, 'store'])->name('manager.orders.store');
    Route::get   ('manager/orders',                     [App\Http\Controllers\Admin\AdminController::class, 'all_order'])->name('manager.orders.index');
    Route::get   ('manager/orders/{id}',                [App\Http\Controllers\Admin\AllorderController::class, 'show'])->name('manager.orders.show');
    Route::get   ('manager/orders/{id}/edit',           [App\Http\Controllers\Admin\OrderController::class, 'edit'])->name('manager.orders.edit');
    Route::put   ('manager/orders/{id}',                [App\Http\Controllers\Admin\OrderController::class, 'update'])->name('manager.orders.update');
    Route::patch ('manager/orders/{id}/status',         [App\Http\Controllers\Admin\AllorderController::class, 'updateStatus'])->name('manager.orders.status');
    Route::patch ('manager/orders/{id}/assign-staff',   [App\Http\Controllers\Admin\AdminController::class, 'assignStaff'])->name('manager.orders.assign-staff');
    Route::delete('manager/orders/{id}',                [App\Http\Controllers\Admin\AllorderController::class, 'destroy'])->name('manager.orders.destroy');
    Route::post  ('manager/orders/{order}/send-steadfast', [App\Http\Controllers\Admin\SteadfastOrderController::class, 'send'])->name('manager.orders.steadfast.send');
    Route::post  ('manager/orders/{order}/send-pathao',    [App\Http\Controllers\Admin\PathaoOrderController::class, 'send'])->name('manager.orders.pathao.send');

    // ── Categories ────────────────────────────────────────────────────────────
    Route::resource('manager/category',    App\Http\Controllers\Admin\CategoryController::class,    ['as' => 'manager']);
    Route::resource('manager/subcategory', App\Http\Controllers\Admin\SubCategoryController::class, ['as' => 'manager']);
    Route::resource('manager/products',    App\Http\Controllers\Admin\ProductController::class,     ['as' => 'manager']);

    // ── Coupons ───────────────────────────────────────────────────────────────
    Route::get   ('manager/coupons',          [App\Http\Controllers\Admin\CouponController::class, 'index']  )->name('manager.coupon.index');
    Route::get   ('manager/coupons/create',   [App\Http\Controllers\Admin\CouponController::class, 'create'] )->name('manager.coupon.create');
    Route::post  ('manager/coupons',          [App\Http\Controllers\Admin\CouponController::class, 'store']  )->name('manager.coupon.store');
    Route::get   ('manager/coupons/{id}/edit',[App\Http\Controllers\Admin\CouponController::class, 'edit']   )->name('manager.coupon.edit');
    Route::put   ('manager/coupons/{id}',     [App\Http\Controllers\Admin\CouponController::class, 'update'] )->name('manager.coupon.update');
    Route::delete('manager/coupons/{id}',     [App\Http\Controllers\Admin\CouponController::class, 'destroy'])->name('manager.coupon.destroy');

    // ── Reviews ───────────────────────────────────────────────────────────────
    Route::post  ('manager/reviews/bulk',           [App\Http\Controllers\Admin\AdminproductReviewController::class, 'bulk']     )->name('manager.reviews.bulk');
    Route::get   ('manager/reviews',                [App\Http\Controllers\Admin\AdminproductReviewController::class, 'index']    )->name('manager.reviews.index');
    Route::post  ('manager/reviews/{id}/approve',   [App\Http\Controllers\Admin\AdminproductReviewController::class, 'approve']  )->name('manager.reviews.approve');
    Route::post  ('manager/reviews/{id}/unapprove', [App\Http\Controllers\Admin\AdminproductReviewController::class, 'unapprove'])->name('manager.reviews.unapprove');
    Route::delete('manager/reviews/{id}',           [App\Http\Controllers\Admin\AdminproductReviewController::class, 'destroy']  )->name('manager.reviews.destroy');

    // ── Chat ──────────────────────────────────────────────────────────────────
    Route::prefix('manager/chat')->name('manager.chat.')->group(function () {
        Route::get ('/',                       [App\Http\Controllers\Admin\AdminChatController::class, 'index']      )->name('index');
        Route::get ('/unread-count',           [App\Http\Controllers\Admin\AdminChatController::class, 'unreadCount'])->name('unread');
        Route::get ('/{chatSession}',          [App\Http\Controllers\Admin\AdminChatController::class, 'show']       )->name('show');
        Route::post('/{chatSession}/reply',    [App\Http\Controllers\Admin\AdminChatController::class, 'reply']      )->name('reply');
        Route::get ('/{chatSession}/messages', [App\Http\Controllers\Admin\AdminChatController::class, 'getMessages'])->name('messages');
        Route::post('/{chatSession}/close',    [App\Http\Controllers\Admin\AdminChatController::class, 'close']      )->name('close');
    });

    // ── Blog ──────────────────────────────────────────────────────────────────
    Route::resource('manager/blog-categories', App\Http\Controllers\Admin\BlogCategoryController::class, ['as' => 'manager']);
    Route::resource('manager/blog-posts', App\Http\Controllers\Admin\BlogPostController::class, ['as' => 'manager']);

    // ── Purchase Management ────────────────────────────────────
    Route::resource('manager/suppliers', SupplierController::class, ['as' => 'manager']);
    Route::resource('manager/purchases', PurchaseController::class, ['as' => 'manager']);
    Route::get('manager/purchase-report', [PurchaseReportController::class, 'stockReport'])->name('manager.purchases.report');
});

// ══════════════════════════════════════════════════════════════════════════════
// SUB-ADMIN
// ══════════════════════════════════════════════════════════════════════════════
Route::get ('subadmin/login',        [SubadminController::class, 'subadmin_login']       )->name('subadmin.login');
Route::post('subadmin/login/submit', [SubadminController::class, 'subadmin_login_submit'])->name('subadmin.login.submit');
Route::get ('subadmin/logout',       [SubadminController::class, 'subadmin_logout']      )->name('subadmin.logout');

Route::middleware(['subadmin'])->group(function () {
    Route::get('subadmin/dashboard', [SubadminController::class, 'subadmin_dashboard'])->name('subadmin.dashboard');
});
