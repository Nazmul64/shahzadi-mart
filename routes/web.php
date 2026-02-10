<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Saller\SallerController;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', [FrontendController::class, 'frontend'])->name('frontend');

Route::get('customer', [FrontendController::class, 'user_dashboard'])->name('user.dashboard');
Route::get('dashboard', [AdminController::class, 'admin_dashboard'])->name('admin.dashboard');
Route::get('saller/dashboard', [SallerController::class, 'saller_dashboard'])->name('saller.dashboard');
