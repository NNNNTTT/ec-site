<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;


/*Route::get('/', function () {
    return view('welcome');
});*/

Route::name('product')
    ->group(function(){
        Route::get('/', [ProductController::class, 'index'])->name('.index');
        Route::get('/product/{id}', [ProductController::class, 'show'])->name('.show');
    });
