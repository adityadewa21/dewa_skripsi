<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\CartController;

Route::any('/',[IndexController::class, 'index'])->name('index');
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.process');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/category-product/{slug}', [CategoryController::class, 'byCategory'])->name('products.category');
Route::get('/contact', [IndexController::class, 'contact'])->name('contact');
Route::get('/products', [ProductController::class, 'all'])->name('products.all');

Route::middleware('auth')->group(function () {
    // ✅ TARUH INI DULU
    Route::get('/checkout/cart', [CheckoutController::class, 'cart'])->name('checkout.cart');
    Route::post('/checkout/cart', [CheckoutController::class, 'storeCart'])->name('checkout.cart.store');

    // ❗ BARU INI
    Route::get('/checkout/{product:slug}', [CheckoutController::class, 'index'])->name('checkout.index');
});
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout-success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
Route::post('/cart/add', [CartController::class, 'add'])
    ->name('cart.add')
    ->middleware('auth');
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');
});
Route::get('/track-order', [TrackingController::class, 'track'])->name('order.track');
Route::post('/result-track', [TrackingController::class, 'result'])->name('order.result-track');

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');

            // CATEGORY
            Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
            Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
            Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
            Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
            Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
            Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

            /// PRODUCTS
            Route::get('/products', [ProductController::class, 'index'])->name('products');
            Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
            Route::post('/products', [ProductController::class, 'store'])->name('products.store');
            Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
            Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
            Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

            Route::post('/product-variants', [ProductVariantController::class,'store'])->name('product-variants.store');
            Route::put('/product-variants/{variant}', [ProductVariantController::class,'update'])->name('product-variants.update');
            Route::delete('/product-variants/{variant}', [ProductVariantController::class,'destroy'])->name('product-variants.destroy');

            // PRODUCT VARIANTS
            Route::post('/product-variants', [ProductVariantController::class, 'store'])
                ->name('product-variants.store');
            Route::put('/product-variants/{variant}', [ProductVariantController::class, 'update'])
                ->name('product-variants.update');
            Route::delete('/product-variants/{variant}', [ProductVariantController::class, 'destroy'])
                ->name('product-variants.destroy');

            // PRODUCT IMAGES
            Route::post('/product-images', [ProductImageController::class,'store'])
                ->name('product-images.store');
            Route::put('/product-images/{image}/primary', [ProductImageController::class,'setPrimary'])
                ->name('product-images.primary');
            Route::delete('/product-images/{image}', [ProductImageController::class,'destroy'])
                ->name('product-images.destroy');

            Route::get('/orders', [AdminController::class, 'order'])
                ->name('orders.order');
            Route::get('/orders/{order}', [AdminController::class, 'show'])
                ->name('orders.show');
            Route::patch('/orders/{order}', [AdminController::class, 'updateStatus'])
                ->name('orders.update');

            Route::get('/customers', [AdminController::class, 'index'])
                ->name('admin.customers');
            Route::get('/customers/{user}', [AdminController::class, 'detailCustomer'])
                ->name('admin.customers-show');

            Route::get('/analytics/products', [AdminController::class, 'monthlySales'])
                ->name('admin.analytics');
            Route::get('/analytics/products/{product}', [AdminController::class, 'detailMonthlySales'])
                ->name('admin.analytics-show');
});

Route::middleware(['auth', 'customer'])
    ->prefix('customer')
    ->group(function () {

        Route::get('/dashboard', [CustomerController::class, 'dashboard'])
            ->name('customer.dashboard');

        Route::get('/profile', [CustomerController::class, 'profile'])->name('customer.profile');
        Route::put('/profile-update', [CustomerController::class, 'updateProfile'])->name('customer.updateProfile');
        Route::get('/my-orders', [CustomerController::class, 'myOrders'])->name('customer.order');
        Route::get('/my-orders/{order}', [CustomerController::class, 'show'])->name('customer.detailOrder');
});
