<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterData\AreaController;
use App\Http\Controllers\MasterData\BrandController;
use App\Http\Controllers\MasterData\ProductController;
use App\Http\Controllers\MasterData\RetailController;
use App\Http\Controllers\UserManagement\UserAccessController;
use App\Http\Controllers\UserManagement\UserManagementController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return view('auth.login');
});

Auth::routes();

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/area', [AreaController::class, 'index'])->name('area.index');
    Route::post('/area/store', [AreaController::class, 'store'])->name('area.store');
    Route::patch('/area/{id}', [AreaController::class, 'update'])->name('area.update');
    Route::delete('/area/{id}', [AreaController::class, 'destroy'])->name('area.destroy');

    Route::get('/brand', [BrandController::class, 'index'])->name('brand.index');
    Route::post('/brand/store', [BrandController::class, 'store'])->name('brand.store');
    Route::patch('/brand/{id}', [BrandController::class, 'update'])->name('brand.update');
    ROute::delete('/brand/{id}', [BrandController::class, 'destroy'])->name('brand.destroy');

    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    Route::patch('/product/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');

    Route::get('/retail', [RetailController::class, 'index'])->name('retail.index');
    Route::post('/retail/store', [RetailController::class, 'store'])->name('retail.store');

    Route::get('/user-management', [UserManagementController::class, 'index'])->name('user_management.index');
    Route::post('/user-management/store', [UserManagementController::class, 'store'])->name('user_management.store');
    Route::patch('/user-management/{id}', [UserManagementController::class, 'update'])->name('user_management.update');
    Route::delete('/user-management/{id}', [UserManagementController::class, 'destroy'])->name('user_management.destroy');

    Route::get('/user-access', [UserAccessController::class, 'index'])->name('user_access.index');
    Route::patch('/user-access/{id}', [UserAccessController::class, 'update'])->name('user_access.update');
});
