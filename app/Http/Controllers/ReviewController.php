<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Product;
use App\Models\Order;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function create($order_id, $product_id){
        $user_id = Auth::id();

        $order = Order::find($order_id);
        if($order->user_id !== $user_id){
            return redirect()->route('mypage.order_detail', $order_id);
        }else{
            return view('mypage.review.create')
            ->with('product', Product::find($product_id))
            ->with('order_id', $order_id);
        }
    }

    public function store(StoreReviewRequest $request){

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
            return redirect()->route('mypage.order_detail', $request->order_id)->with('success', '商品レビューを登録しました');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', '商品レビューの登録に失敗しました');
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

    public function product_review_update(UpdateReviewRequest $request, $id){

        DB::beginTransaction();
        try{
            Review::find($id)->update($request->all());
            DB::commit();
            return redirect()->route('product.show', $request->product_id)->with('success', '商品レビューを更新しました');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', '商品レビューの更新に失敗しました');
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

    public function mypage_review_update(UpdateReviewRequest $request, $order_id, $review_id){

        DB::beginTransaction();
        try{
            Review::find($review_id)->update($request->all());
            DB::commit();
            return redirect()->route('mypage.order_detail', $request->order_id)->with('success', '商品レビューを更新しました');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', '商品レビューの更新に失敗しました');
        }
    }
}
