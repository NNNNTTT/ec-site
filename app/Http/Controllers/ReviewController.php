<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    //
    public function create($id){
        return view('mypage.review.create')
            ->with('product', Product::find($id));
    }

    public function store(Request $request){

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title'     => 'required|string|max:255',
            'comment' => 'required|string',
            'product_id' => 'required|exists:products,id',
        ]);

        DB::beginTransaction();
        try{
            Review::create([
                'product_id' => $request->product_id,
                'user_id' => Auth::user()->id,
                'rating' => $request->rating,
                'title' => $request->title,
                'comment' => $request->comment,
            ]);
            DB::commit();
            return redirect()->route('mypage.order_detail', $request->product_id)->with('success', 'レビューを登録しました');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'レビューの登録に失敗しました');
        }
    }

    public function edit($id){
        $user_id = Auth::id();
        $review = Review::where('user_id', $user_id)->where('product_id', $id)->first();
        $product = Product::find($id);
        return view('mypage.review.edit')
            ->with('product', $product)
            ->with('review', $review);
    }

    public function update(Request $request, $id){
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'comment' => 'required|string',
        ]);



        DB::beginTransaction();
        try{
            Review::find($id)->update($request->all());
            DB::commit();
            return redirect()->route('product.review.edit', $request->product_id)->with('success', 'レビューを更新しました');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'レビューの更新に失敗しました');
        }
    }
}
