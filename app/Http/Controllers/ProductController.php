<?php

namespace App\Http\Controllers;

// リクエストクラス
use Illuminate\Http\Request;

// モデルクラス
use App\Models\Product;

class ProductController extends Controller
{
    // 商品一覧を表示する
    public function index()
    {   
        return view('product.index')
            ->with('products', Product::get());
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
        return view('product.index')
            ->with('products', $products);
    }

}
