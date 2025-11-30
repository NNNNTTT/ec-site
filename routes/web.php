<?php

use App\Http\Controllers\TopController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LineItemController;
use App\Http\Middleware\CartSession;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminSaleController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminProductCategoryController;


use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;


/*
Route::get('/', function () {
    return view('welcome');
});*/

//カートIDがあるか確認してなければ作成するミドルウェア
Route::middleware([CartSession::class])->group(function () {

    Route::get('/', [TopController::class, 'top']);

    Route::name('product')->group(function () {
        Route::get('product', [ProductController::class, 'index'])->name('.index');
        Route::post('/product/search', [ProductController::class, 'search'])->name('.search');
        Route::get('/product/review/edit/{id}', [ReviewController::class, 'product_review_edit'])->name('.review.edit');
        Route::post('/product/review/update/{id}', [ReviewController::class, 'product_review_update'])->name('.review.update');
        Route::get('/product/{parent_slug}/{category_slug}/{id}', [ProductController::class, 'show'])->name('.show');
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

    Route::name('favorite')->group(function(){
        Route::post('/favorite', [FavoriteController::class, 'index'])->name('.index');
        Route::post('/favorite/store', [FavoriteController::class, 'store'])->name('.store');
        Route::post('/favorite/destroy', [FavoriteController::class, 'destroy'])->name('.destroy');
    });
});

Route::name('mypage')->group(function(){
    Route::get('/mypage', [MypageController::class, 'index'])->name('.index');
    Route::get('/mypage/edit', [MypageController::class, 'edit'])->name('.edit');
    Route::post('/mypage/update', [MypageController::class, 'update'])->name('.update');
    Route::get('/mypage/order_detail/{id}', [MypageController::class, 'order_detail'])->name('.order_detail');
    Route::get('/mypage/review/create/{order_id}/{product_id}', [ReviewController::class, 'create'])->name('.review.create');
    Route::post('/mypage/review/store', [ReviewController::class, 'store'])->name('.review.store');
    Route::get('/mypage/review/edit/{order_id}/{product_id}', [ReviewController::class, 'mypage_review_edit'])->name('.review.edit');
    Route::post('/mypage/review/update/{order_id}/{review_id}', [ReviewController::class, 'mypage_review_update'])->name('.review.update');
});

Route::name('admin')->group(function(){
    Route::get('/admin', [AdminController::class, 'index'])->name('.index');
    Route::get('/admin/product', [AdminProductController::class, 'admin_index'])->name('.product.index');
    Route::get('/admin/product/create', [AdminProductController::class, 'create'])->name('.product.create');
    Route::post('/admin/product/store', [AdminProductController::class, 'store'])->name('.product.store');
    Route::get('/admin/product/edit/{id}', [AdminProductController::class, 'edit'])->name('.product.edit');
    Route::post('/admin/product/update/{id}', [AdminProductController::class, 'update'])->name('.product.update');
    Route::get('/admin/product/destroy/{id}', [AdminProductController::class, 'destroy'])->name('.product.destroy');
    Route::get('/admin/product/stock_edit', [AdminProductController::class, 'stock_edit'])->name('.product.stock_edit');
    Route::post('/admin/product/stock_update', [AdminProductController::class, 'stock_update'])->name('.product.stock_update');

    Route::get('/admin/order', [AdminOrderController::class, 'index'])->name('.order.index');
    Route::get('/admin/order/show/{id}', [AdminOrderController::class, 'show'])->name('.order.show');
    Route::post('/admin/order/status_update', [AdminOrderController::class, 'status_update'])->name('.order.status_update');
    Route::get('/admin/order/receipt/{id}', [AdminOrderController::class, 'receipt'])->name('.order.receipt');

    Route::get('/admin/sale/days_show', [AdminSaleController::class, 'days_show'])->name('.sale.days_show');
    Route::post('/admin/sale/days_search', [AdminSaleController::class, 'days_search'])->name('.sale.days_search');
    Route::get('/admin/sale/month_show', [AdminSaleController::class, 'month_show'])->name('.sale.month_show');
    Route::post('/admin/sale/month_search', [AdminSaleController::class, 'month_search'])->name('.sale.month_search');

    Route::get('/admin/product_category', [AdminProductCategoryController::class, 'index'])->name('.product_category.index');
    Route::get('/admin/product_category/create', [AdminProductCategoryController::class, 'create'])->name('.product_category.create');
    Route::post('/admin/product_category/store', [AdminProductCategoryController::class, 'store'])->name('.product_category.store');
    Route::get('/admin/product_category/edit/{id}', [AdminProductCategoryController::class, 'edit'])->name('.product_category.edit');
    Route::post('/admin/product_category/update/{id}', [AdminProductCategoryController::class, 'update'])->name('.product_category.update');
    Route::get('/admin/product_category/destroy/{id}', [AdminProductCategoryController::class, 'destroy'])->name('.product_category.destroy');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/test_mail', function () {
    Mail::to('tsubota456@outlook.jp')->send(new TestMail('テストメールです'));
    return 'メールを送信しました';
});

require __DIR__.'/auth.php';
