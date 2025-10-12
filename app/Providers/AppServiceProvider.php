<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ページネーションをブートストラップに変更
        Paginator::useBootstrap();

        // カテゴリーを全ビューで共有
        $product_categories = ProductCategory::whereNull('parent_id')->get();
        View::share('product_categories', $product_categories);
    }
}
