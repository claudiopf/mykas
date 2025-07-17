<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterData\AreaController;
use App\Http\Controllers\MasterData\BrandController;
use App\Http\Controllers\MasterData\ProductController;
use App\Http\Controllers\MasterData\RetailController;
use App\Http\Controllers\UserManagement\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/area', [AreaController::class, 'index'])->name('area.index');

    Route::get('/brand', [BrandController::class, 'index'])->name('brand.index');
    Route::post('/brand/store', [BrandController::class, 'store'])->name('brand.store');
    Route::patch('/brand/{id}', [BrandController::class, 'update'])->name('brand.update');
    ROute::delete('/brand/{id}', [BrandController::class, 'destroy'])->name('brand.destroy');

    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');

    Route::get('/retail', [RetailController::class, 'index'])->name('retail.index');

    Route::get('/user-management', [UserManagementController::class, 'index'])->name('user_management.index');
    Route::post('/user-management/store', [UserManagementController::class, 'store'])->name('user_management.store');
    Route::patch('/user-management/{id}', [UserManagementController::class, 'update'])->name('user_management.update');
    Route::delete('/user-management/{id}', [UserManagementController::class, 'destroy'])->name('user_management.destroy');
});
