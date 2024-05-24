<?php

use App\Http\Controllers\DataTableController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login-proses', [LoginController::class, 'login_proses'])->name('login-proses');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/register-proses', [LoginController::class, 'register_proses'])->name('register-proses');

Route::group(['prefix'=> 'admin', 'middleware' => ['auth'], 'as' => 'admin.'], function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::get('/user', [HomeController::class, 'index'])->name('index');
    Route::get('/create', [HomeController::class, 'create'])->name('user.create');
    Route::post('/store', [HomeController::class, 'store'])->name('user.store');

    Route::get('/clientside', [DataTableController::class, 'clientside'])->name('clientside');
    Route::get('/serverside', [DataTableController::class, 'serverside'])->name('serverside');

    Route::get('/edit/{id}', [HomeController::class, 'edit'])->name('user.edit');
    Route::put('/update/{id}', [HomeController::class,'update'])->name('user.update');
    Route::delete('/delete/{id}', [HomeController::class,'delete'])->name('user.delete');

    // product
    Route::get('/produk', [ProductController::class,'index'])->name('product');
    Route::get('/produk-create', [ProductController::class,'create'])->name('product.create');
    Route::post('/produk-store', [ProductController::class,'store'])->name('product.store');
    Route::get('/produk-edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/produk-update/{id}', [ProductController::class,'update'])->name('product.update');
    Route::delete('/produk-delete/{id}', [ProductController::class,'delete'])->name('product.delete');

    // transaction
    Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction');
    Route::post('/transaction-store', [TransactionController::class, 'store'])->name('transaction.store');
    // Route::post('/transaction', [TransactionController::class, 'store'])->name('transaction.store');

});