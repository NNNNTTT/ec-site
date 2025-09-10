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

    public function product_review_edit($id){
        $user_id = Auth::id();
        $review = Review::where('user_id', $user_id)->where('product_id', $id)->first();
        if($review == null){
            return redirect()->route('product.index');
        }else{
            $product = Product::find($review->product_id);
            return view('product.review.edit')
                ->with('product', $product)
                ->with('review', $review);
        }
    }

    public function product_review_update(Request $request, $id){
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'comment' => 'required|string',
        ]);

        DB::beginTransaction();
        try{
            Review::find($id)->update($request->all());
            DB::commit();
            return redirect()->route('product.show', $request->product_id)->with('success', 'レビューを更新しました');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'レビューの更新に失敗しました');
        }
    }

    public function mypage_review_edit($order_id, $product_id){
        $user_id = Auth::id();
        $review = Review::where('user_id', $user_id)->where('product_id', $product_id)->first();
        if($review == null){
            return redirect()->route('mypage.index');
        }else{
            $product = Product::find($review->product_id);
            return view('mypage.review.edit')
                ->with('product', $product)
                ->with('review', $review)
                ->with('order_id', $order_id);
        }
    }

    public function mypage_review_update(Request $request, $order_id, $review_id){
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'comment' => 'required|string',
        ]);

        DB::beginTransaction();
        try{
            Review::find($review_id)->update($request->all());
            DB::commit();
            return redirect()->route('mypage.order_detail', $request->order_id)->with('success', 'レビューを更新しました');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'レビューの更新に失敗しました');
        }
    }
}
