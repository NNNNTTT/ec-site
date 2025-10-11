<?php

namespace App\Http\Controllers;

// リクエストクラス
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductCategoryRequest;
use App\Http\Requests\UpdateProductCategoryRequest;

// モデルクラス
use App\Models\ProductCategory;

// ファサードクラス
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminProductCategoryController extends Controller
{
    // 商品カテゴリ一覧を表示する
    public function index(){
        $show = "product";
        $product_categories = ProductCategory::all();
        return view('admin.product_category.index')
            ->with('show', $show)
            ->with('product_categories', $product_categories);
    }

    // 商品カテゴリ登録画面を表示する
    public function create(){
        $show = "product";
        $product_categories = ProductCategory::whereNull('parent_id')->get();
        return view('admin.product_category.create')
            ->with('show', $show)
            ->with('product_categories', $product_categories);
    }
    
    // 商品カテゴリ登録を行う
    public function store(StoreProductCategoryRequest $request){
        $show = "product";
        DB::beginTransaction();
        try{
            $product_category = ProductCategory::create($request->all());
            DB::commit();
            return redirect()->route('admin.product_category.index')
                ->with('show', $show)
                ->with('product_category', $product_category)
                ->with('success', '商品カテゴリ登録に成功しました');
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e);
            return redirect()->route('admin.product_category.create')
                ->with('error', '商品カテゴリ登録に失敗しました');
        }
    }

    // 商品カテゴリ編集画面を表示する
    public function edit($id){
        $show = "product";
        $product_category = ProductCategory::find($id);
        $product_categories = ProductCategory::whereNull('parent_id')->get();
        return view('admin.product_category.edit')
            ->with('show', $show)
            ->with('product_category', $product_category)
            ->with('product_categories', $product_categories);
    }

    // 商品カテゴリ編集を行う
    public function update(UpdateProductCategoryRequest $request, $id){
        $show = "product";
        DB::beginTransaction();
        try{
            $product_category = ProductCategory::find($id);
            $product_category->update($request->all());
            DB::commit();
            return redirect()->route('admin.product_category.index')
                ->with('show', $show)
                ->with('success', '商品カテゴリを更新しました')
                ->with('product_category', $product_category);
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e);
            return redirect()->route('admin.product_category.edit', $id)
                ->with('error', '商品カテゴリを更新できませんでした')
                ->with('show', $show);
        }
    }

    // 商品カテゴリ削除を行う
    public function destroy($id){
        $show = "product";
        DB::beginTransaction();
        try{
            $product_category = ProductCategory::find($id);
            $product_category->delete();
            DB::commit();
            return redirect()->route('admin.product_category.index')
                ->with('show', $show)
                ->with('success', '商品カテゴリを削除しました')
                ->with('product_category', $product_category);
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e);
            return redirect()->route('admin.product_category.edit', $id)
                ->with('error', '商品カテゴリを削除できませんでした')
                ->with('show', $show);
        }
    }
}