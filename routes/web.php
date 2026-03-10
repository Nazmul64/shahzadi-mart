<?php

use App\Http\Controllers\Admin\AdminauthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminsellerregisterapprovedController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ChildSubCategoryController;
use App\Http\Controllers\Admin\EmpleeController;
use App\Http\Controllers\Admin\PermissionController;
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

// Roles
 // Dashboard


Route::resource('roles', RoleController::class);
// Role এ Permission assign করার dedicated page
Route::get('roles/{role}/assign-permission',[RoleController::class, 'assignPermission'])->name('roles.assignPermission');
Route::put('roles/{role}/save-assigned-permission',[RoleController::class, 'saveAssignedPermission'])->name('roles.saveAssignedPermission');
// ── Permissions ────────────────────────────────────────────────────────────────
// Bulk create আগে রাখতে হবে, নইলে Laravel "bulk-create" কে {permission} মনে করবে
Route::post('permissions/bulk-create',[PermissionController::class, 'bulkCreate'])->name('permissions.bulkCreate');
Route::resource('permissions', PermissionController::class);
// ── Users ──────────────────────────────────────────────────────────────────────
Route::resource('users', UserController::class);
Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
// ── Category Start ──────────────────────────────────────────────────────────────────────
// ===== Category Routes =====
Route::resource('category', CategoryController::class);
Route::get('category/{id}/toggle-featured', [CategoryController::class, 'toggleFeatured'])->name('category.toggle-featured');
Route::get('category/{id}/toggle-status',   [CategoryController::class, 'toggleStatus'])->name('category.toggle-status');

// ===== SubCategory Routes =====
Route::resource('subcategory', SubCategoryController::class);
Route::get('subcategory/{id}/toggle-featured', [SubCategoryController::class, 'toggleFeatured'])->name('subcategory.toggle-featured');
Route::get('subcategory/{id}/toggle-status',   [SubCategoryController::class, 'toggleStatus'])->name('subcategory.toggle-status');

// ===== ChildSubCategory Routes =====
Route::resource('childcategory', ChildSubCategoryController::class);
Route::get('childcategory/{id}/toggle-featured', [ChildSubCategoryController::class, 'childtoggleFeatured'])->name('childcategory.toggle-featured');
Route::get('childcategory/{id}/toggle-status',   [ChildSubCategoryController::class, 'childtoggleStatus'])->name('childcategory.toggle-status');

// AJAX: Get SubCategories by Category ID
Route::get('get-subcategories', [ChildSubCategoryController::class, 'getSubCategories'])->name('childcategory.getSubCategories');


// ── Category End ──────────────────────────────────────────────────────────────────────
});

// ─── Auth Routes (Login/Register) ───────────────────────────
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');







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


// emplee route start
Route::get('emplee/login', [EmpleeController::class, 'emplee'])->name('emplee.login');
Route::post('emplee/login/submit', [EmpleeController::class, 'loginSubmit'])->name('emplee.login.submit');
Route::post('emplee/logout', [EmpleeController::class, 'emplee_logout'])->name('emplee.logout');

Route::middleware(['emplee'])->group(function () {
    Route::get('emplee', [EmpleeController::class, 'emplee_dashboard'])->name('emplee.dashboard');
});
// emplee route end

// Manager route start
Route::get('manager/login', [ManagerController::class, 'manager_login'])->name('manager.login');
Route::post('manager/login/submit', [ManagerController::class, 'manager_login_submit'])->name('manager.login.submit');
Route::get('manager/logout', [ManagerController::class, 'manager_logout'])->name('manager.logout');

Route::middleware(['manager'])->group(function () {
    Route::get('manager/dashboard', [ManagerController::class, 'manager_dashboard'])->name('manager.dashboard');
});
// Manager route end

// Subadmin route start
Route::get('subadmin/login', [SubadminController::class, 'subadmin_login'])->name('subadmin.login');
Route::post('subadmin/login/submit', [SubadminController::class, 'subadmin_login_submit'])->name('subadmin.login.submit');
Route::get('subadmin/logout', [SubadminController::class, 'subadmin_logout'])->name('subadmin.logout');

Route::middleware(['subadmin'])->group(function () {
    Route::get('subadmin/dashboard', [SubadminController::class, 'subadmin_dashboard'])->name('subadmin.dashboard');
});
// Subadmin route end






