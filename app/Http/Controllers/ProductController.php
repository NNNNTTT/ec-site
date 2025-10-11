<?php

namespace App\Http\Controllers;

// リクエストクラス
use Illuminate\Http\Request;

// モデルクラス
use App\Models\Product;
use App\Models\ProductCategory;

class ProductController extends Controller
{
    // 商品一覧を表示する
    public function index($parent_slug = null, $category_slug = null)
    {   
        if($category_slug){
            $category = ProductCategory::where('slug', $category_slug)->first();
            $category_id = $category->id;
            $category_name = $category->name;
            $products = $category->products;

        }else if($parent_slug){
            $category = ProductCategory::where('slug', $parent_slug)->first();
            $category_id = $category->id;
            $category_name = $category->name;
            $products = ProductCategory::where('parent_id', $category_id)->first()->products;

        }else{
            $products = Product::get();
            $category_name = '全ての商品';
        }
        $product_categories = ProductCategory::whereNull('parent_id')->get();
        return view('product.index')
            ->with('products', $products)
            ->with('product_categories', $product_categories)
            ->with('category_name', $category_name);
    }

    // 商品詳細を表示する
    public function show($parent_slug, $category_slug, $id)
    {
        return view('product.show')
            ->with('product', Product::find($id));
    }

    // 商品検索を行う
    public function search(Request $request){
        $products = Product::where('name', 'like', '%' . $request->input('search') . '%')->get();
        $product_categories = ProductCategory::whereNull('parent_id')->get();
        $category_name = '全ての商品';
        return view('product.index')
            ->with('products', $products)
            ->with('product_categories', $product_categories)
            ->with('category_name', $category_name);

    }

}
