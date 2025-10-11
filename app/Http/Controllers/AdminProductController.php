<?php

namespace App\Http\Controllers;

// リクエストクラス
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

// モデルクラス
use App\Models\Product;
use App\Models\ProductCategory;

// ファサードクラス
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminProductController extends Controller
{
    // 商品一覧を表示する(管理者用)
    public function admin_index()
    {
        $show = "product";
        return view('admin.product.index')
            ->with('products', Product::get())
            ->with('show', $show);
    }

    // 商品登録画面を表示する(管理者用)
    public function create()
    {
        $show = "product";
        $product_categories = ProductCategory::whereNotNull('parent_id')->get();
        return view('admin.product.create')
            ->with('show', $show)
            ->with('product_categories', $product_categories);
    }

    // 商品登録を行う(管理者用)
    public function store(StoreProductRequest $request)
    {   
        // トランザクションを開始　途中でエラーが起きた場合全てのデータベースの変更を取り消せる
        DB::beginTransaction();
        try{
            // 商品を作成する
            $product = Product::create([
                'name' => $request->name,
                'category_id' => $request->product_category_id,
                'price' => $request->price,
                'description' => $request->description,
                'stock' => $request->stock,
                'image' => '', // 初期値は空　後で保存する
            ]);

            if($request->hasFile('image')){
                $this->saveImage($request, $product);
            }

            $show = "product";

            DB::commit(); // トランザクションをコミット データベースの変更を確定

            return redirect()->route('admin.product.index')
                ->with('success', '商品登録に成功しました')
                ->with('show', $show);

        }catch(\Exception $e){
            DB::rollBack(); // トランザクションをロールバック データベースの変更を取り消す
            Log::error($e); // エラーをログに保存 ログのパスはstorage/logs/laravel.log
            return redirect()->route('admin.product.create')
                ->with('error', '商品登録に失敗しました')
                ->with('show', $show);
        }
    }

    // 商品編集画面を表示する(管理者用)
    public function edit($id){

        $show = "product"; // 管理者用のページで商品一覧のトグルを開いた状態で表示するための設定　これがないとエラーになる
        $product_categories = ProductCategory::whereNotNull('parent_id')->get();

        // 商品編集画面を表示
        return view('admin.product.edit')
            ->with('show', $show)
            ->with('product', Product::find($id))
            ->with('product_categories', $product_categories);
    }

    // 商品編集を行う(管理者用)
    public function update(UpdateProductRequest $request, $id){

        // 管理者用のページで商品一覧のトグルを開いた状態で表示するための設定　これがないとエラーになる
        $show = "product";

        // トランザクションを開始　途中でエラーが起きた場合全てのデータベースの変更を取り消せる
        DB::beginTransaction();
        try{
            $product = Product::find($id);
            $product->name = $request->name;
            $product->category_id = $request->product_category_id;
            $product->price = $request->price;
            $product->description = $request->description;
            $product->stock = $request->stock;
            $product->save();

            if($request->hasFile('image')){
                $this->saveImage($request, $product);
            }

            DB::commit(); // トランザクションをコミット データベースの変更を確定

            return redirect()->route('admin.product.edit', $id)->with('success', '商品を更新しました')
                ->with('show', $show);

        }catch(\Exception $e){
            DB::rollBack(); // トランザクションをロールバック データベースの変更を取り消す
            Log::error($e); // エラーをログに保存 ログのパスはstorage/logs/laravel.log

            return redirect()->route('admin.product.edit', $id)->with('error', '商品を更新できませんでした')
                ->with('show', $show);
        }
    }

    // 商品削除を行う(管理者用)
    public function destroy($id){
        DB::beginTransaction();
        try{
            $product = Product::find($id);
            $product->delete();
            $show = "product";

            DB::commit(); // トランザクションをコミット データベースの変更を確定

            return redirect()->route('admin.product.index')->with('success', '注文ID' . $id . 'の商品を削除しました')
                ->with('show', $show);

        }catch(\Exception $e){
            DB::rollBack(); // トランザクションをロールバック データベースの変更を取り消す
            Log::error($e); // エラーをログに保存 ログのパスはstorage/logs/laravel.log

            return redirect()->route('admin.product.edit', $id)->with('error', '注文ID' . $id . 'の商品を削除できませんでした')
                ->with('show', $show);
        }
    }


    // 在庫編集画面を表示する(管理者用)
    public function stock_edit(){
        $show = "product";
        $products = Product::all();
        return view('admin.product.stock_edit')
            ->with('products', $products)
            ->with('show', $show);
    }

    // 在庫編集を行う(管理者用)
    public function stock_update(Request $request){
        $show = "product";
        $select_productIds = $request->products;
        
        foreach($select_productIds as $productId){
            $productId = intval($productId);
            $product = Product::find($productId);
            $product->stock = $request->stock[$productId];
            $product->save();
        }
        return redirect()->route('admin.product.stock_edit')
            ->with('success', '在庫を更新しました')
            ->with('show', $show);
    }
    
    /**
     * 商品画像を保存
     * - ファイル名は商品IDを使用
     * - storage/public/images に保存
     * - 保存後、商品モデルにパスを更新
     */
    private function saveImage($request, $product){
        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = $product->id . '.' . $extension;
        $request->file('image')->storeAs('images', $filename, 'public');
        $product->image = 'storage/images/' . $filename;
        $product->save();
    }
}
