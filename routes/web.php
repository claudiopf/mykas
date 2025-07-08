<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserManagement\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/user-management', [UserManagementController::class, 'index'])->name('user_management.index');
    Route::post('/user-management/store', [UserManagementController::class, 'store'])->name('user_management.store');
    Route::patch('/user-management/{id}', [UserManagementController::class, 'update'])->name('user_management.update');
});
