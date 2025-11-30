<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// モデルクラス
use App\Models\Product;
use App\Models\ProductCategory;

// ファサードクラス
use Illuminate\Support\Facades\DB;


class TopController extends Controller
{
    public function top(){
        $products = Product::take(3)->get();
        $product_categories = ProductCategory::where('parent_id', null)->get();
        $product_arrivals = Product::orderBy('created_at', 'desc')->take(3)->get();

        $products_ranking = Product::select('products.*', DB::raw('SUM(order_product.quantity) as total_quantity'))
            ->leftJoin('order_product', 'products.id', '=', 'order_product.product_id')
            ->groupBy('products.id')
            ->orderByDesc('total_quantity')
            ->take(3)
            ->get();

        
        return view('top', compact('products', 'product_categories', 'product_arrivals', 'products_ranking'));
    }
}
