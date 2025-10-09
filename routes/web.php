<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;



// Redirect root to product listing (home)
Route::get('/', [ProductController::class, 'index'])->name('home');

// Product details page
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');



Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add'); //this is putting into the cart... 
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');


Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/place', [CheckoutController::class, 'store'])->name('checkout.store');

Route::get('/dashboard', function () {
    return view('dashboard'); // looks for resources/views/dashboard.blade.php
})->middleware(['auth'])->name('dashboard');

// routes/web.php
Route::get('/posts', function () {
    return 'Posts page coming soon';
})->name('posts.index');


Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', AdminProductController::class); // index/create/store/edit/update/destroy/show(optional)
});


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::middleware(['auth'])->group(function () {

//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
//     // Post resource routes (only for logged-in users)
//     Route::resource('posts', App\Http\Controllers\PostController::class);
// });


// Protected dashboard route (only logged-in users can access)
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

// This file includes Breeze authentication routes (login, register, logout, etc.)
require __DIR__.'/auth.php';
