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
        return view('admin.product.index')
            ->with('products', Product::get());
    }

    public function create()
    {
        return view('admin.product.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        DB::beginTransaction();
        try{       
            $product = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
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
        return view('admin.product.edit')
            ->with('product', Product::find($id));
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'description' => 'required|string',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();
        try{
            $product = Product::find($id);
            $product->name = $request->name;
            $product->price = $request->price;
            $product->description = $request->description;
            $product->save();

            if($request->hasFile('image')){
                $this->saveImage($request, $product);
            }

            DB::commit();
            return redirect()->route('admin.product.edit', $id)->with('success', '商品を更新しました');

        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e);
            return redirect()->route('admin.product.edit', $id)->with('error', '商品を更新できませんでした');
        }
    }

    public function destroy($id){
        $product = Product::find($id);
        $product->delete();
        return redirect()->route('admin.product.index')->with('success', $id . '番の商品を削除しました');
    }

    private function saveImage($request, $product){
        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = $product->id . '.' . $extension;
        $request->file('image')->storeAs('images', $filename, 'public');
        $product->image = 'storage/images/' . $filename;
        $product->save();
    }
}
