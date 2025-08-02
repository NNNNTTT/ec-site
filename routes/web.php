<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\CartSession;
use App\Http\Controllers\LineItemController;
use App\Http\Controllers\CartController;

/*Route::get('/', function () {
    return view('welcome');
});*/

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
    });

});

