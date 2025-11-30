<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// モデルクラス
use App\Models\Product;
use App\Models\ProductCategory;

class TopController extends Controller
{
    public function top(){
        $products = Product::take(3)->get();
        $product_categories = ProductCategory::where('parent_id', null)->get();
        
        return view('top', compact('products', 'product_categories'));
    }
}
