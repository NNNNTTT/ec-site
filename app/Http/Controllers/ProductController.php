<?php

namespace App\Http\Controllers;

// リクエストクラス
use Illuminate\Http\Request;

// モデルクラス
use App\Models\Product;
use App\Models\ProductCategory;

// ファサードクラス
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // 商品一覧を表示する
    public function index(Request $request)
    {   
        if($request->query('category_slug')){
            $category = ProductCategory::where('slug', $request->query('category_slug'))->first();
            $category_id = $category->id;
            $category_name = $category->name;
            $products = $category->products()->paginate(6)->withQueryString();

        }else if($request->query('parent_slug')){
            $category = ProductCategory::where('slug', $request->query('parent_slug'))->first();
            $category_id = $category->id;
            $category_name = $category->name;
            $products = ProductCategory::where('parent_id', $category_id)->first()->products()->paginate(6)->withQueryString();

        }else if($request->query('ranking')){
            $products = Product::select('products.*', DB::raw('SUM(order_product.quantity) as total_quantity'))
            ->leftJoin('order_product', 'products.id', '=', 'order_product.product_id')
            ->groupBy('products.id')
            ->orderByDesc('total_quantity')
            ->paginate(6)
            ->withQueryString();
            $category_name = '全ての商品';
            $filter = 'ranking';
        }else if($request->query('arrivals')){
            $products = Product::orderBy('created_at', 'desc')->paginate(6)->withQueryString();
            $category_name = '全ての商品';
            $filter = 'arrival';
        }
        else{
            $products = Product::orderBy('created_at', 'desc')->paginate(6)->withQueryString();
            $category_name = '全ての商品';
        }

        if(empty($filter)){
            $filter = '';
        }
        return view('product.index')
            ->with('products', $products)
            ->with('category_name', $category_name)
            ->with('filter', $filter);
    }

    // 商品詳細を表示する
    public function show($parent_slug, $category_slug, $id)
    {
        return view('product.show')
            ->with('product', Product::find($id));
    }

    // 商品検索を行う
    public function search(Request $request){
        $products = Product::where('name', 'like', '%' . $request->input('search') . '%')->paginate(6);
        $category_name = '全ての商品';
        $filter = '';
        return view('product.index')
            ->with('products', $products)
            ->with('category_name', $category_name)
            ->with('filter', $filter);

    }

}
