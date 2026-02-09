<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Frontend\FrontendController;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', [FrontendController::class, 'frontend'])->name('frontend');
Route::get('dashboard', [AdminController::class, 'admin_dashboard'])->name('admin.dashboard');
