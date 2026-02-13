<?php

use App\Http\Controllers\Admin\AdminauthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminsellerregisterapprovedController;
use App\Http\Controllers\Frontend\FrontendauthContorller;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Saller\SallerController;
use App\Http\Controllers\Saller\SellerauthController;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', [FrontendController::class, 'frontend'])->name('frontend');
// customer route start

Route::get('customer/login', [FrontendauthContorller::class, 'customer_login'])->name('customer.login');
Route::post('customer/login/submit', [FrontendauthContorller::class, 'customer_login_submit'])->name('customer.login.submit'); // ✅ Changed to POST
Route::post('/customer/register', [FrontendauthContorller::class, 'customer_register_submit'])->name('customer.register.submit');
Route::post('/customer/logout', [FrontendauthContorller::class, 'customer_logout'])->name('customer.logout');

Route::middleware(['customer'])->group(function () {
   Route::get('customer', [FrontendController::class, 'user_dashboard'])->name('user.dashboard');
});
// customer route end


// admin route start
Route::get('admin/login', [AdminauthController::class, 'admin_login'])->name('admin.login');
Route::post('/admin/login', [AdminauthController::class, 'admin_login_submit'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminauthController::class, 'admin_logout'])->name('admin.logout');
Route::middleware(['admin'])->group(function () {
    Route::get('dashboard', [AdminController::class, 'admin_dashboard'])->name('admin.dashboard');
    Route::get('sellerregistercheck', [AdminsellerregisterapprovedController::class, 'seller_register_check'])->name('seller.register.check');
    Route::get('seller/register/status', [AdminsellerregisterapprovedController::class, 'seller_register_status'])->name('seller.register.status');
    Route::get('/seller-registrations', [AdminsellerregisterapprovedController::class, 'seller_register_check'])->name('seller.register.list');
    // Approve seller
    Route::put('/seller-registrations/{id}/approve', [AdminsellerregisterapprovedController::class, 'seller_register_approve'])->name('seller.register.approve');
    // Reject seller
    Route::put('/seller-registrations/{id}/reject', [AdminsellerregisterapprovedController::class, 'seller_register_reject'])->name('seller.register.reject');
    // Suspend seller
    Route::put('/seller-registrations/{id}/suspend', [AdminsellerregisterapprovedController::class, 'seller_register_suspend'])->name('seller.register.suspend');
    // Reactivate seller
    Route::put('/seller-registrations/{id}/reactivate', [AdminsellerregisterapprovedController::class, 'seller_register_reactivate'])->name('seller.register.reactivate');
    // Export sellers to Excel/CSV
    Route::get('/seller-registrations/export', [AdminsellerregisterapprovedController::class, 'seller_register_export'])->name('seller.register.export');
    // View detailed seller information
    Route::get('/seller-registrations/{id}/view', [AdminsellerregisterapprovedController::class, 'seller_register_view'])->name('seller.register.view');
});

// admin route end



// saller route start
Route::get('seller/login', [SellerauthController::class, 'saller_login'])->name('saller.login');
Route::get('seller/register', [SellerauthController::class, 'saller_register'])->name('saller.register');
Route::post('seller/login', [SellerauthController::class, 'saller_login_submit'])->name('saller.login.submit');
Route::post('seller', [SellerauthController::class, 'saller_register_submit'])->name('saller.register.submit');
Route::middleware(['saller'])->group(function () {
    Route::get('saller/dashboard', [SellerauthController::class, 'saller_dashboard'])->name('saller.dashboard');
    Route::post('/logout', [SellerauthController::class, 'saller_logout'])->name('logout');

});

// saller route end







