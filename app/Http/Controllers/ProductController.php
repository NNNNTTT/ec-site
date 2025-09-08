<?php

namespace App\Http\Controllers;
use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    //
    public function index()
    {   
        return view('product.index')
            ->with('products', Product::get());
    }

    public function show($id)
    {
        return view('product.show')
            ->with('product', Product::find($id));
    }

    public function admin_index()
    {
        $show = "product";
        return view('admin.product.index')
            ->with('products', Product::get())
            ->with('show', $show);
    }

    public function create()
    {
        $show = "product";
        return view('admin.product.create')
            ->with('show', $show);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        DB::beginTransaction();
        try{       
            $product = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
                'stock' => $request->stock,
                'image' => '',
            ]);

            if($request->hasFile('image')){
                $this->saveImage($request, $product);
            }

            DB::commit();
            return redirect()->route('admin.product.create')->with('success', '商品登録に成功しました');

        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e);
            return redirect()->route('admin.product.create')->with('error', '商品登録に失敗しました');
        }
    }

    public function edit($id){
        $show = "product";
        return view('admin.product.edit')
            ->with('show', $show)
            ->with('product', Product::find($id));
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'description' => 'required|string',
            'stock' => 'required|integer',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $show = "product";

        DB::beginTransaction();
        try{
            $product = Product::find($id);
            $product->name = $request->name;
            $product->price = $request->price;
            $product->description = $request->description;
            $product->stock = $request->stock;
            $product->save();

            if($request->hasFile('image')){
                $this->saveImage($request, $product);
            }

            DB::commit();
            return redirect()->route('admin.product.edit', $id)->with('success', '商品を更新しました')
                ->with('show', $show);

        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e);
            return redirect()->route('admin.product.edit', $id)->with('error', '商品を更新できませんでした')
                ->with('show', $show);
        }
    }

    public function destroy($id){
        $product = Product::find($id);
        $product->delete();
        $show = "product";
        return redirect()->route('admin.product.index')->with('success', $id . '番の商品を削除しました')
            ->with('show', $show);
    }

    public function search(Request $request){
        $products = Product::where('name', 'like', '%' . $request->input('search') . '%')->get();
        return view('product.index')
            ->with('products', $products);
    }

    public function stock_edit(){
        $show = "product";
        $products = Product::all();
        return view('admin.product.stock_edit')
            ->with('products', $products)
            ->with('show', $show);
    }

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

    private function saveImage($request, $product){
        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = $product->id . '.' . $extension;
        $request->file('image')->storeAs('images', $filename, 'public');
        $product->image = 'storage/images/' . $filename;
        $product->save();
    }

}
