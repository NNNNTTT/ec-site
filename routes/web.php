<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LineItemController;
use App\Http\Middleware\CartSession;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
Route::get('/', function () {
    return view('welcome');
});*/

//カートIDがあるか確認してなければ作成するミドルウェア
Route::middleware([CartSession::class])->group(function () {

    Route::name('product')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('.index');
        Route::get('/product/{id}', [ProductController::class, 'show'])->name('.show');
    });

    Route::name('line_item')->group(function(){
        Route::post('/line_item/create', [LineItemController::class, 'create'])->name('.create');
        Route::post('/line_item/delete', [LineItemController::class, 'delete'])->name('.delete');
    });

    Route::name('cart')->group(function(){
        Route::get('/cart', [CartController::class, 'index'])->name('.index');
        Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('.checkout');
        Route::get('/cart/success', [CartController::class, 'success'])->name('.success');
    });

    Route::name('order')->group(function(){
        Route::get('/order', [OrderController::class, 'index'])->name('.index');
        Route::post('/order/login', [OrderController::class, 'login'])->name('.login');
        Route::post('/order/register', [OrderController::class, 'register'])->name('.register');
        Route::post('/order/store', [OrderController::class, 'store'])->name('.store');
        Route::get('/order/card', [OrderController::class, 'card'])->name('.card');
        Route::post('/order/card', [OrderController::class, 'card_customer'])->name('.card_customer');
        Route::get('/order/success', [OrderController::class, 'success'])->name('.success');
    });

});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
