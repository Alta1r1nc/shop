<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\OrdersController;

// Главные маршруты
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Маршруты аутентификации
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
    Route::post('/logout', 'logout')->name('logout');
});

// Профиль пользователя (только для авторизованных)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile'); // Исправлено имя роута
});

// Админ-панель
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Пользователи
    Route::get('/users', [AdminController::class, 'users'])->name('users');

    // Заказы
    Route::get('/orders', [OrdersController::class, 'index'])->name('orders');
    Route::post('/orders/{order}/update-status', [OrdersController::class, 'updateStatus'])->name('orders.update-status');

    // Товары
    Route::resource('products', ProductController::class);
});

// Корзина
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'show'])->name('cart.show');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/update/{product}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
});

// Заказы
Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');

// Страница товара
Route::get('/product/{id}', [HomeController::class, 'showProduct'])->name('product.show');
// routes/web.php
Route::post('/cart/update/{product}', [CartController::class, 'updateQuantity'])->name('cart.update');
