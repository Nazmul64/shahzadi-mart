<?php

use App\Http\Controllers\Admin\AdminauthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminproductReviewController;
use App\Http\Controllers\Admin\AdminsellerregisterapprovedController;
use App\Http\Controllers\Admin\AffiliateproductController;
use App\Http\Controllers\Admin\AllorderController;
use App\Http\Controllers\Admin\CampaigncreateController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ChildSubCategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\EmpleeController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\Productsettingcontroller;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\FrontendauthContorller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Manager\ManagerController;
use App\Http\Controllers\Saller\SallerController;
use App\Http\Controllers\Saller\SellerauthController;
use App\Http\Controllers\Subadmin\SubadminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\GeneralsettingController;
use App\Http\Controllers\Admin\ShippingChargeController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\WebsitefaviconController;
use App\Http\Controllers\Admin\PixelController;
use App\Http\Controllers\Admin\PaymentSettingController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\OrderTrackController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Admin\GoogleTagmanagerController;
use App\Http\Controllers\Admin\PathaocourierController;
use App\Http\Controllers\Admin\PathaoOrderController;
use App\Http\Controllers\Admin\PaymentgetewaymanageController;
use App\Http\Controllers\Admin\SmsgatewaysetupController;
use App\Http\Controllers\Admin\SteadfastcourierController;
use App\Http\Controllers\Admin\SteadfastOrderController;
use App\Http\Controllers\Frontend\BkashController;
use App\Http\Controllers\Frontend\Landingordercontroller;
use App\Http\Controllers\Frontend\ProductReviewController;
use App\Http\Controllers\Frontend\Shurjopaycontroller;
use App\Http\Controllers\Frontend\IncompleteOrderController;
use App\Http\Controllers\Admin\AdminIncompleteOrderController;

Auth::routes();

// ══════════════════════════════════════════════════════════════════════════════
// FRONTEND — PUBLIC PAGES
// ══════════════════════════════════════════════════════════════════════════════
Route::get('/',           [FrontendController::class, 'frontend'])->name('frontend');
Route::get('/product/{slug}', [FrontendController::class, 'productdetails'])->name('product.detail');
Route::get('/contactdetails', [FrontendController::class, 'contactDetails'])->name('contact.details');
Route::get('campaign/manage/{id}', [FrontendController::class, 'campaignManage'])->name('campaign.manage');
Route::get('orderhistory', [FrontendController::class, 'orderHistory'])->name('order.history');
Route::post('landing/order/store', [Landingordercontroller::class, 'store'])->name('order.store');
Route::get('/dashboard', [FrontendController::class, 'user_dashboard'])->name('user.dashboard');
Route::post('/order/cancel/{orderNumber}', [FrontendController::class, 'cancelOrder'])->name('order.cancel');
Route::get('/category/{slug}',                          [FrontendController::class, 'categoryPage'])->name('category.page');
Route::get('/category/{catSlug}/{subSlug}',             [FrontendController::class, 'subCategoryPage'])->name('subcategory.page');
Route::get('/category/{catSlug}/{subSlug}/{childSlug}', [FrontendController::class, 'childCategoryPage'])->name('childcategory.page');
Route::get('/shipping/areas', [ShippingChargeController::class, 'activeAreas'])->name('shipping.areas');
Route::get('/track-order',  [OrderTrackController::class, 'index'])->name('order.track');
Route::post('/track-order', [OrderTrackController::class, 'track'])->name('order.track.search');
Route::get('/search/ajax', [SearchController::class, 'ajax'])->name('search.ajax');
Route::get('/search',      [SearchController::class, 'results'])->name('search.results');
Route::get('/all-products', [FrontendController::class, 'allProducts'])->name('products.all');
Route::get('/shop',         [FrontendController::class, 'shop'])->name('shop');
Route::get('/offers',       [FrontendController::class, 'offers'])->name('offers');
Route::get('/new-arrivals', [FrontendController::class, 'newArrivals'])->name('new-arrivals');
Route::post('/review/store', [ProductReviewController::class, 'store'])->name('review.store');

// ══════════════════════════════════════════════════════════════════════════════
// CART ROUTES
// ══════════════════════════════════════════════════════════════════════════════
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/',               [CartController::class, 'index'])->name('index');
    Route::get('/add/{id}',       [CartController::class, 'add'])->name('add');
    Route::get('/remove/{key}',   [CartController::class, 'remove'])->name('remove');
    Route::get('/increase/{key}', [CartController::class, 'increase'])->name('increase');
    Route::get('/decrease/{key}', [CartController::class, 'decrease'])->name('decrease');
    Route::get('/clear',          [CartController::class, 'clear'])->name('clear');
    Route::post('/coupon',        [CartController::class, 'coupon'])->name('coupon');
    Route::get('/count',          [CartController::class, 'count'])->name('count');
});

// ══════════════════════════════════════════════════════════════════════════════
// WISHLIST ROUTES
// ══════════════════════════════════════════════════════════════════════════════
Route::prefix('wishlist')->group(function () {
    Route::get('/',                      [WishlistController::class, 'index'])->name('wishlist');
    Route::get('/add/{id}',              [WishlistController::class, 'add'])->name('wishlist.add');
    Route::get('/remove/{id}',           [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::get('/clear',                 [WishlistController::class, 'clear'])->name('wishlist.clear');
    Route::get('/move-to-cart/{itemId}', [WishlistController::class, 'moveToCart'])->name('wishlist.moveToCart');
});

// ══════════════════════════════════════════════════════════════════════════════
// CHECKOUT ROUTES
// ══════════════════════════════════════════════════════════════════════════════
Route::prefix('checkout')->group(function () {
    Route::get('/',                      [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/place',                [CheckoutController::class, 'place'])->name('checkout.place');
    Route::get('/success/{orderNumber}', [CheckoutController::class, 'success'])->name('order.success');
});

// ── bKash ─────────────────────────────────────────────────────────────────────
Route::get('/payment/bkash', function () { return view('frontend.bkash_pay'); })->name('bkash.initiate');
Route::post('/payment/bkash/create',  [BkashController::class, 'createPayment'])->name('bkash.create');
Route::get('/payment/bkash/callback', [BkashController::class, 'callback'])->name('bkash.callback');

// ── ShurjoPay ─────────────────────────────────────────────────────────────────
Route::get('/payment/shurjopay',           [Shurjopaycontroller::class, 'initiatePayment'])->name('shurjopay.initiate');
Route::get('/payment/shurjopay/callback',  [ShurjopayController::class, 'callback'])->name('shurjopay.callback');
Route::post('/payment/shurjopay/callback', [ShurjopayController::class, 'callback']);

// ── Incomplete Order AJAX (Frontend — no auth) ────────────────────────────────
Route::prefix('incomplete-order')->name('incomplete.')->group(function () {
    Route::post('save',   [IncompleteOrderController::class, 'save'])->name('save');
    Route::post('update', [IncompleteOrderController::class, 'update'])->name('update');
});

// ══════════════════════════════════════════════════════════════════════════════
// GENERAL AUTH
// ══════════════════════════════════════════════════════════════════════════════
Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',    [AuthController::class, 'login'])->name('login.post');
Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');

// ══════════════════════════════════════════════════════════════════════════════
// CUSTOMER (FRONTEND)
// ══════════════════════════════════════════════════════════════════════════════
Route::get('customer/login',         [FrontendauthContorller::class, 'customer_login'])->name('customer.login');
Route::post('customer/login/submit', [FrontendauthContorller::class, 'customer_login_submit'])->name('customer.login.submit');
Route::get('customer/register',      [FrontendauthContorller::class, 'customer_register'])->name('customer.register');
Route::post('customer/register',     [FrontendauthContorller::class, 'customer_register_submit'])->name('customer.register.submit');
Route::post('customer/logout',       [FrontendauthContorller::class, 'customer_logout'])->name('customer.logout');
Route::middleware(['customer'])->group(function () {
    Route::get('customer/dashboard', [FrontendController::class, 'user_dashboard'])->name('user.dashboard');
});

// ══════════════════════════════════════════════════════════════════════════════
// ADMIN AUTH (public)
// ══════════════════════════════════════════════════════════════════════════════
Route::get('admin/login',   [AdminauthController::class, 'admin_login'])->name('admin.login');
Route::post('admin/login',  [AdminauthController::class, 'admin_login_submit'])->name('admin.login.submit');
Route::post('admin/logout', [AdminauthController::class, 'admin_logout'])->name('admin.logout');

// ══════════════════════════════════════════════════════════════════════════════
// ADMIN — CUSTOMER CRUD
// ══════════════════════════════════════════════════════════════════════════════
Route::middleware(['admin'])->group(function () {
    Route::resource('customer', CustomerController::class);
    Route::post('customer/{id}/status',      [CustomerController::class, 'updateStatus'])->name('customer.status');
    Route::post('customer/{id}/make-vendor', [CustomerController::class, 'makeVendor'])->name('customer.makeVendor');
});

// ══════════════════════════════════════════════════════════════════════════════
// ADMIN — ALL OTHER ROUTES
// ══════════════════════════════════════════════════════════════════════════════
Route::middleware(['admin'])->name('admin.')->group(function () {

    Route::get('dashboard', [AdminController::class, 'admin_dashboard'])->name('dashboard');

    // ── Seller Registration ───────────────────────────────────────────────────
    Route::get('sellerregistercheck',                  [AdminsellerregisterapprovedController::class, 'seller_register_check'])->name('seller.register.check');
    Route::get('seller/register/status',               [AdminsellerregisterapprovedController::class, 'seller_register_status'])->name('seller.register.status');
    Route::get('seller-registrations',                 [AdminsellerregisterapprovedController::class, 'seller_register_check'])->name('seller.register.list');
    Route::put('seller-registrations/{id}/approve',    [AdminsellerregisterapprovedController::class, 'seller_register_approve'])->name('seller.register.approve');
    Route::put('seller-registrations/{id}/reject',     [AdminsellerregisterapprovedController::class, 'seller_register_reject'])->name('seller.register.reject');
    Route::put('seller-registrations/{id}/suspend',    [AdminsellerregisterapprovedController::class, 'seller_register_suspend'])->name('seller.register.suspend');
    Route::put('seller-registrations/{id}/reactivate', [AdminsellerregisterapprovedController::class, 'seller_register_reactivate'])->name('seller.register.reactivate');
    Route::get('seller-registrations/export',          [AdminsellerregisterapprovedController::class, 'seller_register_export'])->name('seller.register.export');
    Route::get('seller-registrations/{id}/view',       [AdminsellerregisterapprovedController::class, 'seller_register_view'])->name('seller.register.view');

    // ── Coupons ───────────────────────────────────────────────────────────────
    Route::resource('coupons', CouponController::class);
    Route::post('coupons/{id}/status', [CouponController::class, 'updateStatus'])->name('coupons.status');

    // ── Roles & Permissions ───────────────────────────────────────────────────
    Route::resource('roles', RoleController::class);
    Route::get('roles/{role}/assign-permission',        [RoleController::class, 'assignPermission'])->name('roles.assignPermission');
    Route::put('roles/{role}/save-assigned-permission', [RoleController::class, 'saveAssignedPermission'])->name('roles.saveAssignedPermission');
    Route::post('permissions/bulk-create', [PermissionController::class, 'bulkCreate'])->name('permissions.bulkCreate');
    Route::resource('permissions', PermissionController::class);

    // ── Users ─────────────────────────────────────────────────────────────────
    Route::resource('users', UserController::class);
    Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');

    // ── Categories ────────────────────────────────────────────────────────────
    Route::resource('category', CategoryController::class);
    Route::get('category/{id}/toggle-featured', [CategoryController::class, 'toggleFeatured'])->name('category.toggle-featured');
    Route::get('category/{id}/toggle-status',   [CategoryController::class, 'toggleStatus'])->name('category.toggle-status');

    // ── Sub-Categories ────────────────────────────────────────────────────────
    Route::resource('subcategory', SubCategoryController::class);
    Route::get('subcategory/{id}/toggle-featured', [SubCategoryController::class, 'toggleFeatured'])->name('subcategory.toggle-featured');
    Route::get('subcategory/{id}/toggle-status',   [SubCategoryController::class, 'toggleStatus'])->name('subcategory.toggle-status');

    // ── Child Categories ──────────────────────────────────────────────────────
    Route::resource('childcategory', ChildSubCategoryController::class);
    Route::get('childcategory/{id}/toggle-featured', [ChildSubCategoryController::class, 'childtoggleFeatured'])->name('childcategory.toggle-featured');
    Route::get('childcategory/{id}/toggle-status',   [ChildSubCategoryController::class, 'childtoggleStatus'])->name('childcategory.toggle-status');
    Route::get('get-subcategories',                  [ChildSubCategoryController::class, 'getSubCategories'])->name('childcategory.getSubCategories');

    // ── Products — AJAX helpers (static BEFORE resource) ─────────────────────
    Route::get('products/get-subcategories',   [ProductController::class, 'getSubCategories'])->name('products.getSubCategories');
    Route::get('products/get-childcategories', [ProductController::class, 'getChildCategories'])->name('products.getChildCategories');
    Route::get('products/deactivated',         [ProductController::class, 'deactivated'])->name('products.deactivated');
    Route::get('products/flash-sales',         [ProductController::class, 'flashSalesIndex'])->name('products.flash-sales');
    Route::get('products/new-arrivals',        [ProductController::class, 'newArrivalsIndex'])->name('products.new-arrivals');
    Route::get('products/bestsellers',         [ProductController::class, 'bestsellersIndex'])->name('products.bestsellers');
    Route::get('products/catalog',             [ProductController::class, 'catalogIndex'])->name('products.catalog');
    Route::get ('products/{id}/toggle-status',     [ProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::get ('products/{id}/catalog-add',       [ProductController::class, 'catalogAdd'])->name('products.catalog.add');
    Route::post('products/{id}/catalog-remove',    [ProductController::class, 'catalogRemove'])->name('products.catalog.remove');
    Route::post('products/{id}/catalog-highlight', [ProductController::class, 'catalogHighlight'])->name('products.catalog.highlight');
    Route::get ('products/{id}/catalog-gallery',   [ProductController::class, 'catalogGallery'])->name('products.catalog.gallery');
    Route::post('products/{id}/toggle-flash-sale',  [ProductController::class, 'toggleFlashSale'])->name('products.toggle-flash-sale');
    Route::post('products/{id}/update-flash-sale',  [ProductController::class, 'updateFlashSale'])->name('products.update-flash-sale');
    Route::post('products/{id}/toggle-new-arrival', [ProductController::class, 'toggleNewArrival'])->name('products.toggle-new-arrival');
    Route::post('products/{id}/toggle-bestseller',  [ProductController::class, 'toggleBestseller'])->name('products.toggle-bestseller');
    Route::resource('products', ProductController::class);

    // ── Product Settings ──────────────────────────────────────────────────────
    Route::get('product-settings',        [Productsettingcontroller::class, 'index'])->name('product.settings.index');
    Route::put('product-settings/update', [Productsettingcontroller::class, 'update'])->name('product.settings.update');

    // ── Affiliate Products ────────────────────────────────────────────────────
    Route::get('affiliateproduct/get-sub-categories',   [AffiliateproductController::class, 'getSubCategories'])->name('affiliateproduct.sub-categories');
    Route::get('affiliateproduct/get-child-categories', [AffiliateproductController::class, 'getChildCategories'])->name('affiliateproduct.child-categories');
    Route::post('affiliateproduct/{id}/toggle-status',  [AffiliateproductController::class, 'toggleStatus'])->name('affiliateproduct.toggle-status');
    Route::resource('affiliateproduct', AffiliateproductController::class);

    // ── General Settings ──────────────────────────────────────────────────────
    Route::post('Generalsettings/upload-logo', [GeneralsettingController::class, 'uploadLogo'])->name('Generalsettings.upload-logo');
    Route::post('Generalsettings/delete-logo', [GeneralsettingController::class, 'deleteLogo'])->name('Generalsettings.delete-logo');
    Route::resource('Generalsettings', GeneralsettingController::class);

    // ── Website Favicon ───────────────────────────────────────────────────────
    Route::post('websitefavicon/upload-logo', [WebsitefaviconController::class, 'uploadLogo'])->name('websitefavicon.upload-logo');
    Route::post('websitefavicon/delete-logo', [WebsitefaviconController::class, 'deleteLogo'])->name('websitefavicon.delete-logo');
    Route::resource('websitefavicon', WebsitefaviconController::class);

    // ── Slider ────────────────────────────────────────────────────────────────
    Route::resource('slider', SliderController::class);

    // ── Shipping ──────────────────────────────────────────────────────────────
    Route::resource('shipping', ShippingChargeController::class)->except(['show']);
    Route::get('/toggle/{shipping}', [ShippingChargeController::class, 'toggleStatus'])->name('toggle');

    // ══════════════════════════════════════════════════════════════════════════
    // ORDERS
    // Static/named routes MUST come BEFORE parameterised ones
    // ══════════════════════════════════════════════════════════════════════════
    Route::delete('orders/bulk-delete', [AllorderController::class, 'bulkDelete'])->name('order.bulk-delete');
    Route::patch ('orders/bulk-status', [AllorderController::class, 'bulkStatus'])->name('order.bulk-status');
    Route::get ('orders/create',        [OrderController::class, 'create'])->name('order.create');
    Route::post('orders',               [OrderController::class, 'store'])->name('order.store');
    Route::get  ('orders',              [AllorderController::class, 'allorder'])->name('order.allorder');
    Route::get  ('orders/{id}',         [AllorderController::class, 'show'])->name('order.show');
    Route::get  ('orders/{id}/edit',    [OrderController::class, 'edit'])->name('order.edit');
    Route::put  ('orders/{id}',         [OrderController::class, 'update'])->name('order.update');
    Route::patch ('orders/{id}/status',         [AllorderController::class, 'updateStatus'])->name('order.status');
    Route::patch ('orders/{id}/payment-status', [AllorderController::class, 'updatePaymentStatus'])->name('order.payment-status');
    Route::delete('orders/{id}',                [AllorderController::class, 'destroy'])->name('order.destroy');

    // ── Steadfast Order (regular orders) ──────────────────────────────────────
    // bulk আগে, তারপর single
    Route::post('orders/bulk-send-steadfast',   [SteadfastOrderController::class, 'bulkSend'])->name('steadfast.bulk-send');
    Route::post('orders/{order}/send-steadfast',[SteadfastOrderController::class, 'send'])->name('steadfast.send');
    Route::get ('steadfast/test',               [SteadfastOrderController::class, 'test'])->name('steadfast.test');

    // ── Pathao Order (regular orders) ────────────────────────────────────────
    // bulk আগে, তারপর single
    Route::post('orders/bulk-send-pathao',   [PathaoOrderController::class, 'bulkSend'])->name('pathao.bulk-send');
    Route::post('orders/{order}/send-pathao',[PathaoOrderController::class, 'send'])->name('pathao.send');
    Route::get ('pathao/test',               [PathaoOrderController::class, 'test'])->name('pathao.test');

    // Pathao AJAX (city/zone/area/store)
    Route::get('pathao/stores', [PathaoOrderController::class, 'getStores'])->name('pathao.stores');
    Route::get('pathao/cities', [PathaoOrderController::class, 'getCities'])->name('pathao.cities');
    Route::get('pathao/zones',  [PathaoOrderController::class, 'getZones'])->name('pathao.zones');
    Route::get('pathao/areas',  [PathaoOrderController::class, 'getAreas'])->name('pathao.areas');

    // Pathao debug
    Route::get('pathao/debug/phone',   [PathaoOrderController::class, 'debugPhone'])->name('pathao.debug.phone');
    Route::get('pathao/debug/payload', [PathaoOrderController::class, 'debugPayload'])->name('pathao.debug.payload');
    Route::get('pathao/debug/token',   [PathaoOrderController::class, 'debugToken'])->name('pathao.debug.token');

    // ── Other resources ───────────────────────────────────────────────────────
    Route::resource('contact', ContactController::class);
    Route::resource('pixels', PixelController::class);
    Route::resource('googletagmanager', GoogleTagmanagerController::class);
    Route::resource('paymentgetewaymanage', PaymentgetewaymanageController::class);
    Route::patch('paymentgetewaymanage/{id}/toggle-status', [PaymentgetewaymanageController::class, 'toggleStatus'])->name('paymentgetewaymanage.toggle-status');
    Route::resource('steadfastcourier', SteadfastcourierController::class);
    Route::get('pathaocourier/generate-token', [PathaocourierController::class, 'generateToken'])->name('pathaocourier.generate-token');
    Route::resource('pathaocourier', PathaocourierController::class);
    Route::resource('Smsgatewaysetup', SmsgatewaysetupController::class);
    Route::resource('campaigncreate', CampaigncreateController::class);

    // ══════════════════════════════════════════════════════════════════════════
    // INCOMPLETE ORDERS (Admin)
    // ══════════════════════════════════════════════════════════════════════════
    // ⚠️ CRITICAL ORDER:
    //   1. Static string routes আগে  (bulk-delete, bulk-status, steadfast/bulk-send, pathao/bulk-send)
    //   2. Parameterised routes পরে  (/{incompleteOrder}/...)
    // ══════════════════════════════════════════════════════════════════════════
    Route::prefix('incomplete-orders')->name('incomplete-orders.')->group(function () {

        // List
        Route::get('/', [AdminIncompleteOrderController::class, 'index'])->name('index');

        // ── Bulk actions (static — MUST be before /{incompleteOrder}) ─────────
        Route::delete('/bulk-delete',  [AdminIncompleteOrderController::class, 'bulkDelete'])->name('bulk-delete');
        Route::patch('/bulk-status',   [AdminIncompleteOrderController::class, 'bulkStatus'])->name('bulk-status');

        // ── Steadfast bulk (static) ───────────────────────────────────────────
        Route::post('/steadfast/bulk-send', [AdminIncompleteOrderController::class, 'steadfastBulkSend'])->name('steadfast.bulk-send');

        // ── Pathao bulk (static) ──────────────────────────────────────────────
        Route::post('/pathao/bulk-send', [AdminIncompleteOrderController::class, 'pathaoBulkSend'])->name('pathao.bulk-send');

        // ── Single record routes (parameterised — AFTER all static routes) ────
        Route::get   ('/{incompleteOrder}',             [AdminIncompleteOrderController::class, 'show'])->name('show');
        Route::delete('/{incompleteOrder}',             [AdminIncompleteOrderController::class, 'destroy'])->name('destroy');
        Route::patch ('/{incompleteOrder}/status',      [AdminIncompleteOrderController::class, 'updateStatus'])->name('update-status');
        Route::patch ('/{incompleteOrder}/contacted',   [AdminIncompleteOrderController::class, 'markContacted'])->name('contacted');
        Route::patch ('/{incompleteOrder}/recovered',   [AdminIncompleteOrderController::class, 'markRecovered'])->name('recovered');

        // ── Steadfast single ──────────────────────────────────────────────────
        Route::post('/{incompleteOrder}/steadfast-send', [AdminIncompleteOrderController::class, 'steadfastSend'])->name('steadfast.send');

        // ── Pathao single ─────────────────────────────────────────────────────
        Route::post('/{incompleteOrder}/pathao-send', [AdminIncompleteOrderController::class, 'pathaoSend'])->name('pathao.send');
    });

    // ── Product Reviews (Admin) ───────────────────────────────────────────────
    Route::get   ('/reviews',              [AdminproductReviewController::class, 'index'])->name('reviews.index');
    Route::post  ('/reviews/{id}/approve', [AdminproductReviewController::class, 'approve'])->name('reviews.approve');
    Route::post  ('/reviews/{id}/unapprove',[AdminproductReviewController::class, 'unapprove'])->name('reviews.unapprove');
    Route::delete('/reviews/{id}',         [AdminproductReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::post  ('/reviews/bulk',         [AdminproductReviewController::class, 'bulk'])->name('reviews.bulk');

    // ── Payment Settings ──────────────────────────────────────────────────────
    Route::get ('/payment-settings',                   [PaymentSettingController::class, 'index'])->name('payment.index');
    Route::post('/payment-settings/bkash',             [PaymentSettingController::class, 'bkashStore'])->name('payment.bkash.store');
    Route::post('/payment-settings/shurjopay',         [PaymentSettingController::class, 'shurjopayStore'])->name('payment.shurjopay.store');
    Route::post('/payment-settings/bkash/toggle',      [PaymentSettingController::class, 'bkashToggle'])->name('payment.bkash.toggle');
    Route::post('/payment-settings/shurjopay/toggle',  [PaymentSettingController::class, 'shurjopayToggle'])->name('payment.shurjopay.toggle');

}); // end admin group

// ── Steadfast Webhook (outside admin auth) ────────────────────────────────────
Route::post('webhook/steadfast', [SteadfastOrderController::class, 'webhook'])->name('steadfast.webhook');

// ══════════════════════════════════════════════════════════════════════════════
// SELLER
// ══════════════════════════════════════════════════════════════════════════════
Route::get ('seller/login',    [SellerauthController::class, 'saller_login'])->name('saller.login');
Route::get ('seller/register', [SellerauthController::class, 'saller_register'])->name('saller.register');
Route::post('seller/login',    [SellerauthController::class, 'saller_login_submit'])->name('saller.login.submit');
Route::post('seller',          [SellerauthController::class, 'saller_register_submit'])->name('saller.register.submit');
Route::middleware(['saller'])->group(function () {
    Route::get ('saller/dashboard', [SellerauthController::class, 'saller_dashboard'])->name('saller.dashboard');
    Route::post('saller/logout',    [SellerauthController::class, 'saller_logout'])->name('saller.logout');
});

// ══════════════════════════════════════════════════════════════════════════════
// EMPLOYEE
// ══════════════════════════════════════════════════════════════════════════════
Route::get ('emplee/login',         [EmpleeController::class, 'emplee'])->name('emplee.login');
Route::post('emplee/login/submit',  [EmpleeController::class, 'loginSubmit'])->name('emplee.login.submit');
Route::post('emplee/logout',        [EmpleeController::class, 'emplee_logout'])->name('emplee.logout');
Route::middleware(['emplee'])->group(function () {
    Route::get('emplee/dashboard', [EmpleeController::class, 'emplee_dashboard'])->name('emplee.dashboard');
});

// ══════════════════════════════════════════════════════════════════════════════
// MANAGER
// ══════════════════════════════════════════════════════════════════════════════
Route::get ('manager/login',         [ManagerController::class, 'manager_login'])->name('manager.login');
Route::post('manager/login/submit',  [ManagerController::class, 'manager_login_submit'])->name('manager.login.submit');
Route::get ('manager/logout',        [ManagerController::class, 'manager_logout'])->name('manager.logout');
Route::middleware(['manager'])->group(function () {
    Route::get('manager/dashboard', [ManagerController::class, 'manager_dashboard'])->name('manager.dashboard');
});

// ══════════════════════════════════════════════════════════════════════════════
// SUB-ADMIN
// ══════════════════════════════════════════════════════════════════════════════
Route::get ('subadmin/login',         [SubadminController::class, 'subadmin_login'])->name('subadmin.login');
Route::post('subadmin/login/submit',  [SubadminController::class, 'subadmin_login_submit'])->name('subadmin.login.submit');
Route::get ('subadmin/logout',        [SubadminController::class, 'subadmin_logout'])->name('subadmin.logout');
Route::middleware(['subadmin'])->group(function () {
    Route::get('subadmin/dashboard', [SubadminController::class, 'subadmin_dashboard'])->name('subadmin.dashboard');
});
